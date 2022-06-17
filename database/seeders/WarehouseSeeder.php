<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @requires Locations & Academies
     *
     * @return void
     */
    public function run()
    {
        Warehouse::factory(12) // a dozen warehouses
            ->create();
    }
}
