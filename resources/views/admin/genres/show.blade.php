@extends('layouts.admin')

@section('title', 'Genre Detail')
@section('page-title', 'Genre Detail')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-lg">
    <h2 class="text-2xl font-bold mb-4 text-[#1e293b]">{{ $genre->name }}</h2>

    @if($genre->image)
        <img src="{{ asset($genre->image) }}" alt="{{ $genre->name }}" class="w-48 h-48 object-cover rounded mb-4">
    @endif

    <p class="text-sm text-gray-500">
        <strong>Created at:</strong> {{ $genre->created_at->format('d M Y, H:i') }} <br>
        <strong>Updated at:</strong> {{ $genre->updated_at->format('d M Y, H:i') }}
    </p>

    <div class="mt-6 flex gap-2">
        <a href="{{ route('admin.genres.edit', $genre) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:opacity-90 transition">
            Edit
        </a>
        <a href="{{ route('admin.genres.index') }}" class="bg-gray-300 text-[#1e293b] px-4 py-2 rounded hover:opacity-80 transition">
            Back
        </a>
    </div>
</div>
@endsection