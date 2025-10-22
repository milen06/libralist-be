<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
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

        $books = [
            ['To Kill a Mockingbird', 1960, ['English']],
            ['1984', 1949, ['English']],
            ['Pride and Prejudice', 1813, ['English']],
            ['The Great Gatsby', 1925, ['English']],
            ['Moby-Dick', 1851, ['English']],
            ['War and Peace', 1869, ['English']],
            ['Crime and Punishment', 1866, ['English']],
            ['The Catcher in the Rye', 1951, ['English']],
            ['The Hobbit', 1937, ['English']],
            ['The Lord of the Rings', 1954, ['English']],
            ['Harry Potter and the Sorcerer\'s Stone', 1997, ['English']],
            ['Harry Potter and the Chamber of Secrets', 1998, ['English']],
            ['Harry Potter and the Prisoner of Azkaban', 1999, ['English']],
            ['The Lion, the Witch and the Wardrobe', 1950, ['English']],
            ['The Alchemist', 1988, ['English']],
            ['The Little Prince', 1943, ['English']],
            ['Brave New World', 1932, ['English']],
            ['The Picture of Dorian Gray', 1890, ['English']],
            ['The Kite Runner', 2003, ['English']],
            ['A Thousand Splendid Suns', 2007, ['English']],
            ['The Da Vinci Code', 2003, ['English']],
            ['Angels & Demons', 2000, ['English']],
            ['The Girl with the Dragon Tattoo', 2005, ['English']],
            ['The Hunger Games', 2008, ['English']],
            ['Catching Fire', 2009, ['English']],
            ['Mockingjay', 2010, ['English']],
            ['The Fault in Our Stars', 2012, ['English']],
            ['The Handmaid\'s Tale', 1985, ['English']],
            ['The Road', 2006, ['English']],
            ['The Shining', 1977, ['English']],
            ['It', 1986, ['English']],
            ['Misery', 1987, ['English']],
            ['The Stand', 1978, ['English']],
            ['Dune', 1965, ['English']],
            ['Foundation', 1951, ['English']],
            ['Fahrenheit 451', 1953, ['English']],
            ['The Martian', 2011, ['English']],
            ['The Name of the Wind', 2007, ['English']],
            ['A Game of Thrones', 1996, ['English']],
            ['A Clash of Kings', 1998, ['English']],
            ['A Storm of Swords', 2000, ['English']],
            ['The Color Purple', 1982, ['English']],
            ['Beloved', 1987, ['English']],
            ['The Bell Jar', 1963, ['English']],
            ['The Godfather', 1969, ['English']],
            ['The Old Man and the Sea', 1952, ['English']],
            ['For Whom the Bell Tolls', 1940, ['English']],
            ['The Sun Also Rises', 1926, ['English']],
            ['One Hundred Years of Solitude', 1967, ['English']],
            ['Love in the Time of Cholera', 1985, ['English']],
            ['The Metamorphosis', 1915, ['English']],
            ['The Stranger', 1942, ['English']],
            ['The Trial', 1925, ['English']],
            ['The Brothers Karamazov', 1880, ['English']],
            ['Anna Karenina', 1877, ['English']],
            ['Madame Bovary', 1856, ['English']],
            ['Les Misérables', 1862, ['English']],
            ['The Hunchback of Notre-Dame', 1831, ['English']],
            ['Don Quixote', 1605, ['English']],
            ['The Count of Monte Cristo', 1844, ['English']],
            ['The Three Musketeers', 1844, ['English']],
            ['Dracula', 1897, ['English']],
            ['Frankenstein', 1818, ['English']],
            ['The Time Machine', 1895, ['English']],
            ['The War of the Worlds', 1898, ['English']],
            ['The Call of the Wild', 1903, ['English']],
            ['White Fang', 1906, ['English']],
            ['The Grapes of Wrath', 1939, ['English']],
            ['Of Mice and Men', 1937, ['English']],
            ['East of Eden', 1952, ['English']],
            ['The Outsiders', 1967, ['English']],
            ['Gone with the Wind', 1936, ['English']],
            ['The Secret Garden', 1911, ['English']],
            ['Little Women', 1868, ['English']],
            ['Anne of Green Gables', 1908, ['English']],
            ['The Wind-Up Bird Chronicle', 1994, ['English']],
            ['Norwegian Wood', 1987, ['English']],
            ['Kafka on the Shore', 2002, ['English']],
            ['The Girl on the Train', 2015, ['English']],
            ['The Goldfinch', 2013, ['English']],
            ['The Secret History', 1992, ['English']],
            ['The Book Thief', 2005, ['English']],
            ['Life of Pi', 2001, ['English']],
            ['The Giver', 1993, ['English']],
            ['The Help', 2009, ['English']],
            ['Sapiens', 2011, ['English']],
            ['Educated', 2018, ['English']],
            ['Becoming', 2018, ['English']],
            ['Steve Jobs', 2011, ['English']],
            ['Elon Musk', 2015, ['English']],
            ['The Diary of a Young Girl', 1947, ['English']],
            ['The Art of War', -500, ['English']],
            ['The Prince', 1532, ['English']],
            ['The 7 Habits of Highly Effective People', 1989, ['English']],
            ['Thinking, Fast and Slow', 2011, ['English']],
            ['Atomic Habits', 2018, ['English']],
            ['Laskar Pelangi', 2005, ['Indonesian']],
            ['Bumi Manusia', 1980, ['Indonesian']],
            ['Ayat-Ayat Cinta', 2004, ['Indonesian']],
            ['Negeri 5 Menara', 2009, ['Indonesian']],
        ];

        $authors = Author::all();
        $genres = Genre::all();
        
        foreach ($books as $i => $row) {
            [$title, $year, $langs] = $row;

            $book = Book::updateOrCreate(
                ['slug' => Str::slug($title) . '-' . ($i + 1)],
                [
                    'title'        => $title,
                    'author_id'    => $authors->random()->id,
                    'image'        => 'https://source.unsplash.com/seed/' . Str::slug($title) . '/400x600?book',
                    'short_desc'   => 'A renowned book titled "' . $title . '" by ' . $authors->random()->name . '.',
                    'synopsis'     => "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><br><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><br><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>",
                    'published_at' => $this->yearToDate($year),
                    'languages'    => json_encode($langs),
                ]
            );

            $book->genres()->attach($genres->random()->take(3)->pluck('id')->toArray());
        }
    }

    private function yearToDate(int $year): string
    {
        // Untuk karya kuno (contoh Sun Tzu), fallback ke 1900-01-01
        if ($year <= 0) return '1900-01-01';
        return $year . '-01-01';
    }
}
