<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FullSeeder extends Seeder
{
    /**
     * Run all database seeders
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LocationSeeder::class,
            AcademySeeder::class,
            WarehouseSeeder::class,
            
            RoleSeeder::class,
            SuperUserSeeder::class,
            RoledUsersSeeder::class,
            UserSeeder::class,
            
            ArticleSeeder::class,

            LoanSeeder::class,
            RequestLoanSeeder::class,

            // add other seeders here
        ]);
    }
}
