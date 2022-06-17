<?php

namespace Database\Factories;

use App\Models\RequestLoan;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Article;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RequestLoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RequestLoan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $users = User::all();
        $articles = Article::all();

        return [
            'user_id' => $users->random()->id,
            'article_id' => $articles->random()->id, 
            'amount' => $this->faker->numberBetween(1, 5),
            'loaning_start' => date_format($this->faker->dateTimeBetween('-4 years', 'now'), "Y/m/d H:i:s"),
            'loaning_end' =>  date_format($this->faker->dateTimeBetween('now', '+4 years'), "Y/m/d H:i:s"),

        ];
    }
}
