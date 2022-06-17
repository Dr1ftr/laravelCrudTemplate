<?php

namespace Tests\Feature;

use App\Mail\AccountCreatedMailable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use Database\Factories\UserFactory;
use App\Models\Role;
use Illuminate\Support\Facades\Mail;

class UserCreationTest extends TestCase
{
    /**
     * Test that a super user can make an user,
     * that the user is added to the database
     * and that a mail is sent to the user.
     *
     * @return void
     */
    public function test_super_user_can_make_user()
    {
        // run roleSeeder to get basic roles
        $this->seed("RoleSeeder");
        
        $user = User::factory()->create();
        $user->assignRoles("super-user");

        // turn off the mailer
        Mail::fake();

        // ignore "Expected type 'Illuminate\Contracts\Auth\Authenticatable'. Found type 'App\Models\User'"
        $this->actingAs($user)
            ->get( route("user.create") )
            ->assertStatus(200); // assert that going to user.create didn"t give an error
        
        // ignore "Expected type 'Illuminate\Contracts\Auth\Authenticatable'. Found type 'App\Models\User'"
        $response = $this->actingAs($user)
            ->post( route("user.create.post"), [
                "firstName" => "Cave",
                "lastName" => "Johnson",
                "email" => "CaveJohnson@Aperture.com"
            ])
            ->assertRedirect( route("user.create") ); // assert that the user was redirected to the user index
            
        $this->followRedirects($response) // after getting redirected
            ->assertSeeText( __("Succesfully created user.") ); // assert that we see the success message

        Mail::assertQueued(AccountCreatedMailable::class, 1); // assert that we sent one email (in the queue)

        $createdUser = User::where([
            "firstName" => "Cave",
            "lastName" => "Johnson",
            "email" => "CaveJohnson@Aperture.com"
        ])->first();
        $this->assertNotNull($createdUser, "Assert that the user was added to the database");
    }

    /**
     * Test that a created user has got the specified roles
     *
     * @return void
     */
    public function test_created_user_has_given_roles()
    {
        // run roleSeeder to get basic roles
        $this->seed("RoleSeeder");
        
        $user = User::factory()->create();
        $user->assignRoles("super-user");

        $roles = Role::all(["id", "name"]);

        // turn off the mailer (not for testing, just for not sending emails)
        Mail::fake();

        // ignore "Expected type 'Illuminate\Contracts\Auth\Authenticatable'. Found type 'App\Models\User'"
        $response = $this->actingAs($user)
            ->post( route("user.create.post"), [
                "firstName" => "Taylor",
                "lastName" => "Otwell",
                "email" => "TaylorOtwell@laravel.com",
                "roles" => $roles->pluck("id")->toArray()
            ]);

        $createdUser = User::where([
            "firstName" => "Taylor",
            "lastName" => "Otwell",
            "email" => "TaylorOtwell@laravel.com"
        ])->first();
        $this->assertNotNull($createdUser, "Assert that the user was added to the database");
        
        foreach($roles as $role) { // for each specified role
            // assert that it has been given to the user
            $this->assertTrue($createdUser->hasRole($role->name), "Assert that the created user has role '$role->name'");
        }
    }

    /**
     * Test the content of the created user mail
     *
     * @return void
     */
    public function test_create_user_mail_has_correct_content()
    {
        $user = User::factory()->create();
    
        $mailable = new AccountCreatedMailable($user->id, "abcdefg", $user->getFullName(), []);

        // check that the __ has created an account for you appears in both the html and text versions
        $mailable->assertSeeInHtml( __("mail.account-made", ["name" => $user->getFullName()]) );
        $mailable->assertSeeInText( __("mail.account-made", ["name" => $user->getFullName()]) );

        // check that "got roles:" isn't in the html or text versions, because no roles were given
        $mailable->assertDontSeeInHtml( __("mail.gotten-roles") );
        $mailable->assertDontSeeInText( __("mail.gotten-roles") );

        // check that the link to verify the account appears in both the html and text versions
        $mailable->assertSeeInHtml( route("user.activate", ["userId" => $user->id, "code" => "abcdefg"]) );
        $mailable->assertSeeInText( route("user.activate", ["userId" => $user->id, "code" => "abcdefg"]) );

        // check that a "not meant for you" message is in both the html and text versions
        $mailable->assertSeeInHtml( __("mail.not-meant-for-you") );
        $mailable->assertSeeInHtml( __("mail.not-meant-for-you2") );
        $mailable->assertSeeInText( __("mail.not-meant-for-you") );
        $mailable->assertSeeInText( __("mail.not-meant-for-you2") );



        // new mail with roles
        $mailable = new AccountCreatedMailable($user->id, "gfedcba", $user->getFullName(), [
            ["name" => "admin"], // Fake roles, with similair format to what the database has
            ["name" => "user"],
            ["name" => "super-user"],
            ["name" => "super-admin"]
        ]);

        // check that "got roles:" is in the html and text version this time
        $mailable->assertSeeInHtml( __("mail.gotten-roles") );
        $mailable->assertSeeInText( __("mail.gotten-roles") );

        $mailable->assertSeeInOrderInHtml([
            "Admin", "User", "Super User", "Super Admin"
        ]); // check that the roles appear in the correct order in the html version

        $mailable->assertSeeInOrderInText([
            "Admin", "User", "Super User", "Super Admin"
        ]); // check that the roles appear in the correct order in the text version
    }

    /**
     * Test whether a user can activate using the activation link
     *
     * @return void
     */
    public function test_created_user_can_activate()
    {
        $user = User::factory()->unverified()->create([
            "password" => "code"
        ]);

        $this
            ->get( route("user.activate", ["userId" => $user->id, "code" => "code"]) ) // go to activate route
            ->assertStatus(200); // assert page is ok

        $response =
        $this->post( route("user.activate.post", ["userId" => $user->id, "code" => "code"]), [
                "password" => "really long password that should match the requirements 0123456789!",
                "password_confirmation" => "really long password that should match the requirements 0123456789!"
            ])
            ->assertRedirect( route("login-page") ); // assert that the user was redirected to the login page
            
        $this->followRedirects($response) // after getting redirected
            ->assertSeeText( __('Your account has been succesfully activated. You can now log in.') ); // assert that we see the success message

        $this->assertTrue( isset($user->fresh()->email_verified_at), 'Assert that user is verified' ); // assert that the user is activated
    }

    /**
     * Test whether the create user page has input validation
     *
     * @return void
     */
    public function test_create_user_page_has_validation()
    {
        $user = User::factory()->create();
        $user->assignRoles("super-user");

        // ignore "Expected type 'Illuminate\Contracts\Auth\Authenticatable'. Found type 'App\Models\User'"
        $this->actingAs($user)
            ->post( route("user.create.post") )
            ->assertSessionHasErrors(["firstName", "lastName", "email"]); // assert that there is validation for these fields
    }

    /**
     * Test whether the activate user page has input validation
     *
     * @return void
     */
    public function test_activate_user_page_has_validation()
    {
        $user = User::factory()->unverified()->create([
            "password" => "code"
        ]);
        
        $this
            ->post( route("user.activate.post", ["userId" => $user->id, "code" => "code"]) )
            ->assertSessionHasErrors(["password", "password_confirmation"]); // assert that there is validation for these fields
    }

    /**
     * Test whether the activation page can be accessed with invalid url parameters
     * 
     * @return void
     */
    public function test_activation_page_cannot_be_accessed_with_invalid_url_parameters()
    {
        $user = User::factory()->unverified()->create([
            "password" => "code"
        ]);
        $password = "really long password that should match the requirements 0123456789!";

        $this
            ->get( route("user.activate", ["userId" => $user->id, "code" => "false code"]) )
            ->assertStatus(404); // assert that the page is inaccessible with the wrong code

        $this
            ->get( route("user.activate", ["userId" => $user->id+1, "code" => "code"]) )
            ->assertStatus(404); // assert that the page is inaccessible with the wrong id



        $this
            ->post( route("user.activate.post", ["userId" => $user->id, "code" => "false code"]), [
                "password" => $password, // with form data, otherwise a 302 redirect would be given
                "password_confirmation" => $password
            ])
            ->assertStatus(404); // assert that the page is inaccessible with the wrong code

        $this
            ->post( route("user.activate.post", ["userId" => $user->id+1, "code" => "code"]), [
                "password" => $password, // with form data, otherwise a 302 redirect would be given
                "password_confirmation" => $password
            ])
            ->assertStatus(404); // assert that the page is inaccessible with the wrong id
    }
}
