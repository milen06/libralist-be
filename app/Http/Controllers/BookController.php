<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        // load author dan genres (many-to-many)
        $books = Book::with(['author', 'genres'])->latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        $genres = Genre::all();
        return view('admin.books.create', compact('authors', 'genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:books,slug',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
            'short_desc' => 'required|string',
            'synopsis' => 'required|string',
            'published_at' => 'required|date',
            'languages' => 'required|array',
            'image' => 'required|image|max:2048',
        ]);

        $data = $request->only([
            'title', 'slug', 'author_id', 'short_desc', 'synopsis', 'published_at'
        ]);
        $data['languages'] = json_encode($request->languages);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('uploads/books'); // public/books

            // Buat folder jika belum ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }

            $image->move($destinationPath, $filename);
            $data['image'] = 'uploads/books/' . $filename;
        }

        $book = Book::create($data);
        $book->genres()->attach($request->genres);

        return redirect()->route('admin.books.index')->with('success', 'Book created successfully.');
    }

    public function show(Book $book)
    {
        $book->load(['author', 'genres']);
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        $genres = Genre::all();
        $book->load('genres');

        return view('admin.books.edit', compact('book', 'authors', 'genres'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:books,slug,' . $book->id,
            'author_id' => 'required|exists:authors,id',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
            'short_desc' => 'required|string',
            'synopsis' => 'required|string',
            'published_at' => 'required|date',
            'languages' => 'required|array',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'title', 'slug', 'author_id', 'short_desc', 'synopsis', 'published_at'
        ]);
        $data['languages'] = json_encode($request->languages);

        if ($request->hasFile('image')) {
            // Hapus file lama saat update
            if (isset($book) && $book->image && file_exists(public_path($book->image))) {
                unlink(public_path($book->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('uploads/books');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }

            $image->move($destinationPath, $filename);
            $data['image'] = 'uploads/books/' . $filename;
        }

        $book->update($data);
        $book->genres()->sync($request->genres);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        if ($book->image && file_exists(public_path($book->image))) {
            unlink(public_path($book->image));
        }

        $book->genres()->detach();

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully.');
    }
}