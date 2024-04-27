<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(50, 5),
            'collection_id' => mt_rand(1, 5),
            'isbn' => $this->faker->isbn13(),
            'publisher_id' => mt_rand(1, 5),
            'publish_year' => $this->faker->year(),
            'waqf_id' => mt_rand(1, 5),
            'summary' => $this->faker->realTextBetween(50, 100, 5),
            'page_count' => mt_rand(50, 500),
            'stock' => mt_rand(1, 10),
            'shelf' => 'Rak ' . mt_rand(1, 10) . ' - ' . $this->faker->words(2, true),
        ];
    }
}
