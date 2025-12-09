<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookRating;
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

        if ($request->filled('year')) {
            $year = $request->input('year');
            $books->whereYear('published_at', $year);
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
                case 'latest_release':
                    $books->orderBy('published_at', 'desc');
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

    public function recommended(Request $request)
    {
        $books = Book::with(['author', 'genres', 'ratings.user'])
            ->withAvg('ratings', 'rating');

        // Filter by year (published_at)
        if ($request->filled('year')) {
            $year = $request->input('year');
            $books->whereYear('published_at', $year);
        }

        // Sort rekomendasi
        $sort = $request->input('sort', 'latest_release');

        switch ($sort) {
            case 'popular':
                $books->withCount('ratings')
                    ->orderBy('ratings_count', 'desc');
                break;

            case 'rated':
                $books->orderBy('ratings_avg_rating', 'desc');
                break;

            case 'latest_release':
            default:
                $books->orderBy('published_at', 'desc');
                break;
        }

        $limit = (int) $request->input('limit', 6);

        $recommendedBooks = $books->take($limit)->get();

        return response()->json([
            'recommended_books' => $recommendedBooks,
        ]);
    }

    public function reviews($slug)
    {
        $book = Book::where('slug', $slug)
            ->with(['ratings.user'])
            ->firstOrFail();

        return response()->json([
            'reviews' => $book->ratings,
        ]);
    }

    public function rate(Request $request, $slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        // pastikan user login
        $user = $request->user();

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:2000',
        ]);

        // user hanya boleh 1 rating per buku → update kalau sudah ada
        $rating = BookRating::updateOrCreate(
            [
                'user_id' => $user->id,
                'book_id' => $book->id,
            ],
            [
                'rating' => $data['rating'],
                'review' => $data['review'] ?? '',
            ]
        );

        // refresh average dan list rating
        $book->load(['ratings.user'])
             ->loadAvg('ratings', 'rating');

        return response()->json([
            'message' => 'Rating saved',
            'rating'  => $rating,
            'book'    => $book,
        ]);
    }
}