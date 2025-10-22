<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Author;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalGenres = Genre::count();
        $totalAuthors = Author::count();
        $totalUsers = User::count();

        return view('admin.dashboard', compact('totalBooks', 'totalGenres', 'totalAuthors', 'totalUsers'));
    }
}