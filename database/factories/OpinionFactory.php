<?php

namespace Database\Factories;

use App\Models\Opinion;
use Illuminate\Database\Eloquent\Factories\Factory;

class OpinionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Opinion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rating' => $this->faker->numberBetween(1, 10),
            'content' => $this->faker->text(500),
            'author' => $this->faker->name,
            'email' => $this->faker->email,
            'book_id' => $this->faker->numberBetween(1, 50),
        ];
    }
}
