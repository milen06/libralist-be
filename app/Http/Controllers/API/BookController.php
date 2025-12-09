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
        $limit = (int) $request->input('limit', 4);

        // Filter by year (published_at)
        $yearFilter = $request->filled('year') ? $request->input('year') : null;

        // Jika tidak ada sort parameter, gunakan multi-criteria sorting
        if (!$request->filled('sort')) {
            $books = Book::with(['author', 'genres', 'ratings.user'])
                ->withAvg('ratings', 'rating')
                ->withCount('ratings');

            if ($yearFilter) {
                $books->whereYear('published_at', $yearFilter);
            }

            $books = $books->get();

            // Normalisasi setiap kriteria ke skala 0-1
            $maxRating = $books->max('ratings_avg_rating') ?: 1;
            $maxCount = $books->max('ratings_count') ?: 1;
            
            // Cari buku terbaru dan terlama untuk normalisasi tanggal
            $newestDate = $books->max('published_at');
            $oldestDate = $books->min('published_at');
            $dateRange = $newestDate && $oldestDate 
                ? strtotime($newestDate) - strtotime($oldestDate) 
                : 1;

            // Hitung score untuk setiap buku
            $books = $books->map(function ($book) use ($maxRating, $maxCount, $newestDate, $oldestDate, $dateRange) {
                // Rating score (bobot 40%)
                $ratingScore = ($book->ratings_avg_rating / $maxRating) * 0.4;
                
                // Popular score (bobot 30%)
                $popularScore = ($book->ratings_count / $maxCount) * 0.3;
                
                // Latest release score (bobot 30%)
                $daysFromNewest = $newestDate && $book->published_at
                    ? (strtotime($newestDate) - strtotime($book->published_at)) 
                    : 0;
                $recencyScore = $dateRange > 0 
                    ? (1 - ($daysFromNewest / $dateRange)) * 0.3 
                    : 0;
                
                // Total score
                $book->recommendation_score = $ratingScore + $popularScore + $recencyScore;
                
                return $book;
            });

            // Sort berdasarkan recommendation score
            $recommendedBooks = $books->sortByDesc('recommendation_score')
                ->take($limit)
                ->values();

        } else {
            // Single criteria sorting (existing logic)
            $books = Book::with(['author', 'genres', 'ratings.user'])
                ->withAvg('ratings', 'rating');

            if ($yearFilter) {
                $books->whereYear('published_at', $yearFilter);
            }

            $sort = $request->input('sort');

            switch ($sort) {
                case 'popular':
                    $books->withCount('ratings')
                        ->orderBy('ratings_count', 'desc');
                    break;

                case 'rated':
                    $books->orderBy('ratings_avg_rating', 'desc');
                    break;

                case 'latest_release':
                    $books->orderBy('published_at', 'desc');
                    break;

                default:
                    $books->orderBy('published_at', 'desc');
                    break;
            }

            $recommendedBooks = $books->take($limit)->get();
        }

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