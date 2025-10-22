<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            'Harper Lee',
            'George Orwell',
            'Jane Austen',
            'F. Scott Fitzgerald',
            'Herman Melville',
            'Leo Tolstoy',
            'Fyodor Dostoevsky',
            'J.D. Salinger',
            'J.R.R. Tolkien',
            'J.K. Rowling',
            'C.S. Lewis',
            'Paulo Coelho',
            'Antoine de Saint-Exupéry',
            'Aldous Huxley',
            'Oscar Wilde',
            'Khaled Hosseini',
            'Dan Brown',
            'Stieg Larsson',
            'Suzanne Collins',
            'John Green',
            'Margaret Atwood',
            'Cormac McCarthy',
            'Stephen King',
            'Frank Herbert',
            'Isaac Asimov',
            'Ray Bradbury',
            'Andy Weir',
            'Patrick Rothfuss',
            'George R.R. Martin',
            'Alice Walker',
            'Toni Morrison',
            'Sylvia Plath',
            'Mario Puzo',
            'Ernest Hemingway',
            'Gabriel García Márquez',
            'Franz Kafka',
            'Albert Camus',
            'Gustave Flaubert',
            'Victor Hugo',
            'Miguel de Cervantes',
            'Alexandre Dumas',
            'Bram Stoker',
            'Mary Shelley',
            'H.G. Wells',
            'Jack London',
            'John Steinbeck',
            'S.E. Hinton',
            'Margaret Mitchell',
            'Frances Hodgson Burnett',
            'Louisa May Alcott',
            'L.M. Montgomery',
            'Haruki Murakami',
            'Paula Hawkins',
            'Donna Tartt',
            'Markus Zusak',
            'Yann Martel',
            'Lois Lowry',
            'Kathryn Stockett',
            'Yuval Noah Harari',
            'Tara Westover',
            'Michelle Obama',
            'Walter Isaacson',
            'Ashlee Vance',
            'Anne Frank',
            'Sun Tzu',
            'Niccolò Machiavelli',
            'Stephen R. Covey',
            'Daniel Kahneman',
            'James Clear',
            'Andrea Hirata',
            'Pramoedya Ananta Toer',
            'Habiburrahman El Shirazy',
            'Ahmad Fuadi',
        ];

        foreach ($authors as $name) {
            Author::create([
                'name' => $name,
                'profile_photo' => 'https://i.pravatar.cc/300?u=' . Str::slug($name)
            ]);
        }
    }
}