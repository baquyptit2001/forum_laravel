<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $title = $this->faker->sentence(3);
        $slug = str_slug($title);
        return [
            'title' => $title,
            'question' => $this->faker->paragraph(3, 5),
            'slug' => $slug,
            'views' => $this->faker->numberBetween(0, 1000),
            'user_id' => random_int(1, 21),
        ];
    }
}
