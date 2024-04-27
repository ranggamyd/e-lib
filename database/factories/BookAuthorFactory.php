<?php

namespace Database\Factories;

use App\Models\BookAuthor;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookAuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookAuthor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'book_id' => mt_rand(1, 20),
            'author_id' => mt_rand(1, 5)
        ];
    }
}
