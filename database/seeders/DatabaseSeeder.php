<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            OurLocationSeeder::class,
            OurAcademySeeder::class, // users depend on academies

            RoleSeeder::class, // this seeder is required, users cannot be made without roles
            SuperUserSeeder::class, // cant register account without superuser

            RoledUsersSeeder::class // creates a user for every role
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
