<?php

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Article;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $users = User::all()->toArray();
        $articles = Article::all()->toArray();

        return [
            'user_id' => $this->faker->randomElement($users)["id"] ?? 0,
            'article_id' => $this->faker->randomElement($articles)["id"] ?? 0, 
            'amount' => $this->faker->numberBetween(1, 5),
            'loaning_start' => date_format($this->faker->dateTimeBetween('-4 years', 'now'), "Y/m/d H:i:s"),
            'loaning_end' =>  date_format($this->faker->dateTimeBetween('now', '+4 years'), "Y/m/d H:i:s"),

        ];
    }
}
