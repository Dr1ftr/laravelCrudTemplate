<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // delete old super user
        $user = User::where("email", "usertest@test.com")->delete();

        $now = now(); // run now() once, so we don't have to run it every time we need to use it (because it's slow)

        $user = User::create ([
            "firstName" => "User",
            "lastName" => "Test",
            "email" => "usertest@test.com",
            "email_verified_at" => $now,
            "password" => '$2y$10$aUvHAzDWGyg9ezrSyWeWdeDfR9k1p5OY7zw93gzvxOqQGAj2lLKUm', //hard-coded so it's faster, bcrypt("a")
            "created_at" => $now,
            "updated_at" => $now
        ]);

        $user->assignRole("super-user");
    }
}
