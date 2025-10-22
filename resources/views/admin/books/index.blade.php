@extends('layouts.admin')

@section('title', 'Books')
@section('page-title', 'Books Management')

@section('content')
<div class="flex justify-between mb-5">
    <h2 class="text-lg font-bold text-[#1e293b]">All Books</h2>
    <a href="{{ route('admin.books.create') }}" class="bg-[#e45f65] text-white px-4 py-2 rounded hover:opacity-90 transition">
        + Add Book
    </a>
</div>

<!-- Modal Delete -->
<div x-data="{ open: false, deleteUrl: '' }">
    <!-- Modal Box -->
    <div x-show="open" x-cloak class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div @click.away="open = false" class="bg-white p-6 rounded-lg shadow max-w-sm w-full">
            <h3 class="text-lg font-bold mb-3 text-[#1e293b]">Delete Confirmation</h3>
            <p class="text-gray-600 mb-5">Are you sure you want to delete this book?</p>
            <div class="flex justify-end space-x-2">
                <button @click="open = false" class="bg-gray-300 text-[#1e293b] px-4 py-2 rounded">Cancel</button>
                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:opacity-90 transition">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Data -->
    <table class="min-w-full bg-white rounded-lg shadow overflow-hidden">
        <thead class="bg-[#1e293b] text-white">
            <tr>
                <th class="px-4 py-2 text-left">#</th>
                <th class="px-4 py-2 text-left">Title</th>
                <th class="px-4 py-2">Author</th>
                <th class="px-4 py-2">Genre</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($books as $book)
            <tr>
                <td class="px-4 py-2">{{ $loop->iteration + $books->firstItem() - 1 }}</td>
                <td class="px-4 py-2">{{ $book->title }}</td>
                <td class="px-4 py-2">{{ $book->author->name }}</td>
                <td class="px-4 py-2">
                    @foreach($book->genres as $genre)
                        <span class="inline-block bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs mr-1">
                            {{ $genre->name }}
                        </span>
                    @endforeach
                </td>
                <td class="px-4 py-2 text-center space-x-2">
                    <a href="{{ route('admin.books.show', $book) }}" class="text-blue-600 hover:underline">Detail</a>
                    <a href="{{ route('admin.books.edit', $book) }}" class="text-yellow-600 hover:underline">Edit</a>
                    <button 
                        @click="open = true; deleteUrl='{{ route('admin.books.destroy', $book) }}'" 
                        class="text-red-600 hover:underline">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-5">
        {{ $books->links() }}
    </div>
</div>
@endsection