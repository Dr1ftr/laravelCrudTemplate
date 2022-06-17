<?php

namespace Database\Factories;

use App\Models\Academy;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class WarehouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $now = now();

        $locations = Location::all("id");
        $academies = Academy::all("id");
        
        return [
            'name' => $this->faker->word( $this->faker->numberBetween(1, 3) , true), // 1-3 words as a string

            // DL0.01 - DL5.28
            'room' => "DL{$this->faker->numberBetween(0, 5)}.". str_pad($this->faker->numberBetween(1, 28), 2, '0', STR_PAD_LEFT),

            'location_id' => $locations->random()->id,
            'academy_id' => $academies->random()->id,

            'created_at' => $now,
            'updated_at' => $now
        ];
    }
}
