<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now(); // fire now() once, so all rows have the same time (because it's faster)
        
        // https://stackoverflow.com/a/29723968
        // insert multiple rows using a single insert query thanks to a jagged array
        $roles = [
            ["name" => "super-user"],
            ["name" => "warehouse-admin"],
            ["name" => "financial-admin"],
            ["name" => "student"]
        ];

        // delete the old roles with the same name (if they exist)
        Role::whereIn("name", array_map(
            // map using a php anonymous function, to convert asociative array to indexed array
            fn($row) => $row["name"],
            $roles
        ))->delete();

        // set timestamps in loop for less writing :)
        for($i = 0; $i < count($roles); $i++) {
            // using static created_ and updated_at variables, incase they change...
            $roles[$i][ Role::CREATED_AT ] = $now;
            $roles[$i][ Role::UPDATED_AT ] = $now;
        }

        // insert using an eloquent model method, so all columns get converted if needed
        Role::insert($roles);
    }
}
