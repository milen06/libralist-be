<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CounterVisitorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('books', [App\Http\Controllers\API\BookController::class, 'index']);
Route::get('books/recommended', [App\Http\Controllers\API\BookController::class, 'recommended']);
Route::get('total-reviews', [App\Http\Controllers\API\BookController::class, 'totalReviews']);
Route::get('books/{slug}', [App\Http\Controllers\API\BookController::class, 'show']);
Route::get('genres', [App\Http\Controllers\API\GenreController::class, 'index']);
Route::get('authors', [App\Http\Controllers\API\AuthorController::class, 'index']);
Route::get('authors/{authorId}', [App\Http\Controllers\API\AuthorController::class, 'show']);

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/create-account', [AuthController::class, 'createAccount']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me', [AuthController::class, 'me']);

    Route::get('wishlist-books', [App\Http\Controllers\API\WishlistBookController::class, 'index']);
    Route::post('wishlist-books', [App\Http\Controllers\API\WishlistBookController::class, 'store']);
    Route::delete('wishlist-books/{bookId}', [App\Http\Controllers\API\WishlistBookController::class, 'destroy']);
});

Route::post('/visitors/count', [CounterVisitorController::class, 'count']);
Route::get('/visitors/total', [CounterVisitorController::class, 'total']);