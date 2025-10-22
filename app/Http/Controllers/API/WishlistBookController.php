<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WishlistBookController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $wishlistBooks = $user->wishlistBooks()->with(['author', 'genres', 'ratings'])->withAvg('ratings', 'rating')->get();

        return response()->json(['wishlist_books' => $wishlistBooks]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $user = $request->user();

        if ($user->wishlistBooks()->where('book_id', $request->book_id)->exists()) {
            return response()->json(['message' => 'Book already in wishlist'], 400);
        }

        $user->wishlistBooks()->attach($request->book_id);

        return response()->json(['message' => 'Book added to wishlist'], 201);
    }

    public function destroy(Request $request, $bookId)
    {
        $user = $request->user();

        if (!$user->wishlistBooks()->where('book_id', $bookId)->exists()) {
            return response()->json(['message' => 'Book not found in wishlist'], 404);
        }

        $user->wishlistBooks()->detach($bookId);

        return response()->json(['message' => 'Book removed from wishlist'], 200);
    }
}
