<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookRating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::latest()->get();
        $faker = \Faker\Factory::create();

         $reviewTexts = [
            'Buku ini sangat menarik!',
            'Ceritanya agak membosankan tapi cukup informatif.',
            'Luar biasa, tidak bisa berhenti membacanya!',
            'Gaya penulisan kurang cocok buat saya.',
            'Rekomendasi banget buat semua orang.',
            'Cukup bagus, tapi endingnya terlalu cepat.',
            'Penuh inspirasi!',
            'Plot twist-nya keren!',
            'Kurang mendalam, tapi mudah dipahami.',
            'Sangat menyentuh hati.'
        ];

        foreach ($books as $book) {
            BookRating::create([
                'user_id' => 2,
                'book_id' => $book->id,
                'rating' => rand(3, 5),
                'review' => $faker->randomElement($reviewTexts),
            ]);
        }
    }
}
