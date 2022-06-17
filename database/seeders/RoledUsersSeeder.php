<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\User;

class RoledUsersSeeder extends Seeder
{
    /**
     * Create a user for every role in the database
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::all("id", "name");

        // delete old users with roles in their emails
        User::whereIn(
            "email",
            array_map( // map using a php anonymous function, to convert asociative array to indexed array (with emails)
                fn($row) => "{$row["name"]}@test.com",
                $roles->toArray()
            )
        )->delete();

        $now = now(); // run now once, so we don't have to run it every time we need to use it (because it's slow)

        $userData = [];
        foreach ($roles as $role) {
            // split the role into an array at first dash (subsequent dashes are ignored)
            $nameArray = explode("-", $role->name, 2);

            array_push($userData, [
                "firstName" => $nameArray[0], // the part of the role-name before the dash, or the full role name if there is no dash
                "infix" => $nameArray[1] ?? null, // if there is nothing after the dash in the role's name, then have no infix
                "lastName" => "User", // with the previous rules the full name is "super user User" or "warehouse admin User"
                "email" => "$role->name@test.com", // so email is warehouse-admin@test.com or financial-admin@test.com
                "password" => '$2y$10$aUvHAzDWGyg9ezrSyWeWdeDfR9k1p5OY7zw93gzvxOqQGAj2lLKUm', //hard-coded so it's faster, bcrypt("a")
                "email_verified_at" => $now,
                "created_at" => $now,
                "updated_at" => $now
            ]);
        }

        User::insert($userData);

        // get the inserted users, where their email is inside userData
        $insertedUsers = User::whereIn("email", array_column($userData, "email"))->get();

        foreach($insertedUsers as $index => $user) {
            $user->assignRole($roles[$index]->name);
        }
    }
}
