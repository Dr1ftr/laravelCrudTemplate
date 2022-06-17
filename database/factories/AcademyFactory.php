<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Academy>
 */
class AcademyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $now = now();
        
        return [
            'name' => $this->faker->word( $this->faker->numberBetween(1, 5) , true), // 1-5 words as a string
            'crebo_number' => $this->faker->numberBetween(1000, 26000),

            'created_at' => $now,
            'updated_at' => $now
        ];
    }
}
