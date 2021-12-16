<?php

namespace Database\Factories;

use App\Models\AnswerReply;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerReplyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AnswerReply::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'answer_id' => $this->faker->numberBetween(1, 200),
            'user_id' => $this->faker->numberBetween(1, 16),
            'body' => $this->faker->sentence,
        ];
    }
}
