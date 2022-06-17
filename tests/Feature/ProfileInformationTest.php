<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_current_profile_information_is_available()
    {
        $this->actingAs($user = User::factory()->create());

        $component = Livewire::test(UpdateProfileInformationForm::class);

        $this->assertEquals($user->firstName, $component->state['firstName']);
        $this->assertEquals($user->infix, $component->state['infix']);
        $this->assertEquals($user->lastName, $component->state['lastName']);
        $this->assertEquals($user->email, $component->state['email']);
    }

    public function test_profile_information_can_be_updated()
    {
        $this->actingAs($user = User::factory()->create());

        Livewire::test(UpdateProfileInformationForm::class)
                ->set('state', ['firstName' => 'Rowan', 'infix' => 'Julian', 'lastName' => 'Bean', 'email' => 'mrbean@mail.co.uk'])
                ->call('updateProfileInformation');

        $this->assertEquals('Rowan Julian Bean', $user->fresh()->getFullName());
        $this->assertEquals('mrbean@mail.co.uk', $user->fresh()->email);
    }
}
