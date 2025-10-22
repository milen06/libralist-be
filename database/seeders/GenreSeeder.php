<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genreNames = [
            'Fiction', 'Non-Fiction', 'Science', 'Fantasy', 'Romance',
            'Mystery', 'History', 'Horror', 'Adventure', 'Biography'
        ];

        $genres = collect($genreNames)->map(function ($name) {
            return Genre::create([
                'name' => $name,
                'image' => 'https://source.unsplash.com/400x300/?book,' . strtolower($name),
            ]);
        });
    }
}
