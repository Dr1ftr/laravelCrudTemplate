<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       
            
                $users = User::pluck('id')->toArray();
                return [
                    'user_id' => $this->faker->randomElement($users), 
                    // Rest of attributes...
                    'name_product' => ucwords($this->faker->words(2, true)),
                    'name' => ucwords($this->faker->words(2, true)), // 2 random words as a string (each word starts uppercased)
                    'total_amount' => $this->faker->numberBetween(1, 500), // number between 1 and 500
                    'price' => $this->faker->randomFloat(2, 0, 5_000), // gets converted to and from float by eloquent's mutators/accessor
                ];
            

    }
}
