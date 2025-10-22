@extends('layouts.admin')

@section('title', 'Book Detail')
@section('page-title', 'Book Detail')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-3xl">
    {{-- Judul Buku --}}
    <h2 class="text-2xl font-bold mb-4 text-[#1e293b]">{{ $book->title }}</h2>

    {{-- Slug --}}
    <p class="mb-2">
        <strong>Slug:</strong> {{ $book->slug }}
    </p>

    {{-- Author --}}
    <p class="mb-2">
        <strong>Author:</strong> {{ $book->author->name }}
    </p>

    {{-- Genres --}}
    <p class="mb-2">
        <strong>Genres:</strong>
        @foreach($book->genres as $genre)
            <span class="inline-block bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs mr-1">
                {{ $genre->name }}
            </span>
        @endforeach
    </p>

    {{-- Short Description --}}
    <div class="mb-4">
        <strong>Short Description:</strong>
        <p class="mt-1 text-gray-700">{{ $book->short_desc }}</p>
    </div>

    {{-- Synopsis (HTML Rich Text) --}}
    <div class="mb-4">
        <strong>Synopsis:</strong>
        <div class="mt-1 prose max-w-none">
            {!! $book->synopsis !!}
        </div>
    </div>

    {{-- Published Date --}}
    <p class="mb-2">
        <strong>Published At:</strong> {{ \Carbon\Carbon::parse($book->published_at)->format('d M Y') }}
    </p>

    {{-- Languages --}}
    <p class="mb-4">
        <strong>Languages:</strong>
        @foreach(json_decode($book->languages, true) ?? [] as $lang)
            <span class="inline-block bg-[#e45f65]/10 text-[#e45f65] px-2 py-1 rounded text-xs mr-1">
                {{ $lang }}
            </span>
        @endforeach
    </p>

    {{-- Image --}}
    @if($book->image)
    <div class="mb-6">
        <strong>Book Image:</strong>
        <div class="mt-2">
            <img src="{{ asset($book->image) }}" alt="Cover" class="w-56 rounded shadow">
        </div>
    </div>
    @endif

    {{-- Created / Updated Timestamps --}}
    <p class="text-sm text-gray-500">
        <strong>Created at:</strong> {{ $book->created_at->format('d M Y, H:i') }} <br>
        <strong>Last updated:</strong> {{ $book->updated_at->format('d M Y, H:i') }}
    </p>

    {{-- Actions --}}
    <div class="mt-6 flex gap-2">
        <a href="{{ route('admin.books.edit', $book) }}" 
           class="bg-yellow-500 text-white px-4 py-2 rounded hover:opacity-90 transition">
           Edit
        </a>
        <a href="{{ route('admin.books.index') }}" 
           class="bg-gray-300 text-[#1e293b] px-4 py-2 rounded hover:opacity-80 transition">
           Back
        </a>
    </div>
</div>
@endsection