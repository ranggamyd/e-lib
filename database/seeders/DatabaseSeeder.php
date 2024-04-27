<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            MemberSeeder::class,
            SubjectSeeder::class,
            BookSeeder::class,
            CollectionSeeder::class,
            CategorySeeder::class,
            BookCategorySeeder::class,
            AuthorSeeder::class,
            BookAuthorSeeder::class,
            PublisherSeeder::class,
        ]);
    }
}
