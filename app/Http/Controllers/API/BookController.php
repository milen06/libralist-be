<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with(['author', 'genres', 'ratings.user'])->withAvg('ratings', 'rating');

        if ($request->has('search')) {
            $search = $request->input('search');
            $books->where('title', 'like', "%{$search}%")
                  ->orWhereHas('author', function ($query) use ($search) {
                      $query->where('name', 'like', "%{$search}%");
                  });
        }

        if($request->has('genres')) {
            $genres = $request->input('genres');
            $books->whereHas('genres', function ($query) use ($genres) {
                $query->whereIn('genres.name', (array) $genres);
            });
        }

        if ($request->has('languages')) {
            $languages = (array) $request->input('languages');
            $books->where(function ($query) use ($languages) {
                foreach ($languages as $lang) {
                    $query->orWhereJsonContains('languages', $lang);
                }
            });
        }

        if($request->has('authors')) {
            $authors = (array) $request->input('authors');
            $books->whereHas('author', function ($query) use ($authors) {
                $query->whereIn('name', $authors);
            });
        }

        if ($request->has('sort')) {
            $sort = $request->input('sort');
            switch ($sort) {
                case 'latest':
                    $books->latest();
                    break;
                case 'oldest':
                    $books->oldest();
                    break;
                case 'popular':
                    $books->withCount('ratings')->orderBy('ratings_count', 'desc');
                    break;
                case 'rated':
                    $books->orderBy('ratings_avg_rating', 'desc');
                    break;
            }
        }

        if($request->has('perPage')) {
            $perPage = $request->input('perPage');
            $books = $books->paginate($perPage);
        } else {
            $books = $books->get();
        }

        return response()->json([
            'books' => $books
        ]);
    }

    public function show($slug)
    {
        $book = Book::with(['author', 'genres', 'ratings.user'])->withAvg('ratings', 'rating')->where('slug', $slug)->first();

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json(['book' => $book]);
    }

    public function totalReviews()
    {
        $totalReviews = Book::withCount('ratings')->get()->sum('ratings_count');

        return response()->json([
            'total_reviews' => $totalReviews
        ]);
    }

    public function recommended()
    {
        $recommendedBooks = Book::with(['author', 'genres', 'ratings.user'])
            ->withAvg('ratings', 'rating')
            ->whereHas('ratings', function ($query) {
                $query->where('rating', '>=', 4);
            })
            ->orderByDesc('ratings_avg_rating')
            ->take(6)
            ->get();

        return response()->json([
            'recommended_books' => $recommendedBooks
        ]);
    }
}
