@extends('layouts.admin')

@section('title', 'Genres')
@section('page-title', 'Genres Management')

@section('content')
<div class="flex justify-between mb-5">
    <h2 class="text-lg font-bold text-[#1e293b]">All Genres</h2>
    <a href="{{ route('admin.genres.create') }}" class="bg-[#e45f65] text-white px-4 py-2 rounded hover:opacity-90 transition">
        + Add Genre
    </a>
</div>

<div x-data="{ open: false, deleteUrl: '' }">
    <!-- Modal Delete -->
    <div x-show="open" x-cloak class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div @click.away="open = false" class="bg-white p-6 rounded-lg shadow max-w-sm w-full">
            <h3 class="text-lg font-bold mb-3 text-[#1e293b]">Delete Confirmation</h3>
            <p class="text-gray-600 mb-5">Are you sure you want to delete this genre?</p>
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
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Image</th>
                <th class="px-4 py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($genres as $genre)
            <tr>
                <td class="px-4 py-2">{{ $loop->iteration + $genres->firstItem() - 1 }}</td>
                <td class="px-4 py-2 font-medium">{{ $genre->name }}</td>
                <td class="px-4 py-2">
                    @if($genre->image)
                        <img src="{{ asset($genre->image) }}" alt="{{ $genre->name }}" class="w-14 h-14 object-cover rounded">
                    @endif
                </td>
                <td class="px-4 py-2 text-center space-x-2">
                    <a href="{{ route('admin.genres.show', $genre) }}" class="text-blue-600 hover:underline">Detail</a>
                    <a href="{{ route('admin.genres.edit', $genre) }}" class="text-yellow-600 hover:underline">Edit</a>
                    <button 
                        @click="open = true; deleteUrl='{{ route('admin.genres.destroy', $genre) }}'" 
                        class="text-red-600 hover:underline">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $genres->links() }}
    </div>
</div>
@endsection