<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
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
            'name' => $this->faker->word( $this->faker->numberBetween(2, 4) , true), // 2-4 words as a string

            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'street' => $this->faker->streetName,
            'street_number' => $this->faker->numberBetween(1, 1000),
            'street_number_addition' => $this->faker->optional($weight = .25)->lexify("?"), // random letter (25% chance of being not null)
            'postal_code' => $this->faker->postcode,

            'created_at' => $now,
            'updated_at' => $now
        ];
    }
}
