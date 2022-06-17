<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreatedMailable;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Jetstream;
use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Academy;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    use PasswordValidationRules;

    /**
     * Create a new user
     * 
     * @return \Illuminate\View\View
     */
    public function createUser()
    {
        $roles = Role::all('id', 'id as value', 'name as label'); // get all roles, and only get the id and name
        // id as value and name as label for choices.js

        $academies = Academy::all('id', 'id as value', 'name as label'); // get all academies, and only get the id and name
        // id as value and name as label for choices.js
        
        return view('user.create', [
            'roles' => $roles,
            'academies' => $academies
        ]);
    }
    

    /**
     * Actually make an user in the database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createUserPost(Request $request)
    {
        $request->validate([
            'firstName' => ['required', 'string', 'max:64'],
            'infix' => ['nullable', 'string', 'max:32'],
            'lastName' => ['required', 'string', 'max:128'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

            'academy' => ['nullable', 'integer']
        ]);

        // convert academyId to value for the database
        $academyId = $request->academy ?? null;
        if ($academyId < 1) $academyId = null; // if academyId is -1, set it to null

        // generate a verification code
        $verifyCode = \Illuminate\Support\Str::random(64);

        // create the user
        $user = User::create([
            'firstName' => $request->firstName,
            'infix' => $request->infix ?? NULL,
            'lastName' => $request->lastName,
            'email' => $request->email,

            'academy_id' => $academyId,

            // the verify code is used to verify the account
            'password' => $verifyCode,
        ]);

        // get the roles given to the user
        $givenRoles = Role::whereIn('id', $request->roles ?? [])->get(['id', 'name']); // get the roles that were given

        $rolesData = [];
        foreach($givenRoles as $role) { // foreach role to be given
            array_push($rolesData, [ // prepare ids for the role-user pivot table
                'user_id' => $user->id,
                'role_id' => $role->id
            ]);
        }

        $now = now(); // fire now() once, so all rows have the same time (because it's faster)

        // set timestamps in loop for less writing :)
        for($i = 0; $i < count($rolesData); $i++) {
            // using static created_ and updated_at variables, incase they change...
            $rolesData[$i][ Role::CREATED_AT ] = $now;
            $rolesData[$i][ Role::UPDATED_AT ] = $now;
        }

        // insert the roles into the pivot table if there are any
        if (count($rolesData) > 0) DB::table('user-role')->insert($rolesData);

        // send mail to user that their account has been created
        Mail::to($user->email)->queue(
            new AccountCreatedMailable(
                $user->id, // id of the created user
                $verifyCode, // verify code for the created user
                $request->user()->getFullName(), // full name of the user who created the user
                $givenRoles->toArray() // roles that were given to the user
            )
        );

        // redirect back with msg
        return redirect()->route('user.create')->with('msg', __('Succesfully created user.'));
    }

    /**
     * Shows the activate page
     *
     * @param string $code used to activate account
     * @return \Illuminate\View\View
     */
    public function activateUser(int $userId, string $code)
    {
        try {
            $user = User::findOrFail($userId); // try to find user
        } catch (\Exception $e) {
            abort(404); // if user not found, abort
        }

        if ($user->password != $code) return abort(404); // if the code is incorrect, abort
        
        return view('user.activate', [
            'user' => $user,
            'code' => $code
        ]);
    }

    /**
     * Actually activate the user
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function activateUserPost(Request $request, int $userId, string $code)
    {
        $request->validate([
            'password' => $this->passwordRules(),
            'password_confirmation' => ['required', 'same:password'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ]);

        try {
            $user = User::findOrFail($userId); // try to find user
        } catch (\Exception $e) {
            abort(404); // if user not found, abort
        }

        if ($user->password != $code) return abort(404); // if code is incorrect, abort

        $user->password = Hash::make($request->password); // set the password
        $user->email_verified_at = now(); // set the email verified at time

        $user->save(); // save the changes made to the user

        // redirect with message
        return redirect()->route('login-page')->with('msg', __('Your account has been succesfully activated. You can now log in.'));
    }
}
