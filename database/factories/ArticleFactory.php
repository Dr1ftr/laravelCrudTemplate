<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $now = now();

        $warehouses = Warehouse::all("id");

        return [
            'name' => ucwords($this->faker->words(2, true)), // 2 random words as a string (each word starts uppercased)
            'total_amount' => $this->faker->numberBetween(1, 500), // number between 1 and 500
            'price' => $this->faker->randomFloat(2, 0, 5_000), // gets converted to and from float by eloquent's mutators/accessor

            'warehouse_id' => $warehouses->random()->id, // where this article resides

            'created_at' => $now,
            'updated_at' => $now
        ];
    }
}
