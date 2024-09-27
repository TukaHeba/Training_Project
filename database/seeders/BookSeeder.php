<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'title1',
            'author' => 'author1',
            'published_at' => '2020-11-12',
            'is_active' => true,
            'category_id' => 1,
        ]);
        Book::create([
            'title' => 'title2',
            'author' => 'author2',
            'published_at' => '2020-11-12',
            'is_active' => false,
            'category_id' => 2,
        ]);
        Book::create([
            'title' => 'title3',
            'author' => 'author3',
            'published_at' => '2020-11-12',
            'is_active' => true,
            'category_id' => 3,
        ]);
        Book::create([
            'title' => 'title4',
            'author' => 'author4',
            'published_at' => '2020-11-12',
            'is_active' => true,
            'category_id' => 4,
        ]);
        Book::create([
            'title' => 'title5',
            'author' => 'author5',
            'published_at' => '2020-11-12',
            'is_active' => false,
            'category_id' => 5,
        ]);
        Book::create([
            'title' => 'title6',
            'author' => 'author6',
            'published_at' => '2020-11-12',
            'is_active' => true,
            'category_id' => 6,
        ]);
        Book::create([
            'title' => 'title7',
            'author' => 'author7',
            'published_at' => '2020-11-12',
            'is_active' => false,
            'category_id' => 2,
        ]);
        Book::create([
            'title' => 'title8',
            'author' => 'author8',
            'published_at' => '2020-11-12',
            'is_active' => false,
            'category_id' => 1,
        ]);
    }
}
