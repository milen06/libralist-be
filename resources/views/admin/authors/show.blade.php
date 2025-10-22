@extends('layouts.admin')

@section('title', 'Author Detail')
@section('page-title', 'Author Detail')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-lg text-center">
    <h2 class="text-2xl font-bold mb-4 text-[#1e293b]">{{ $author->name }}</h2>

    @if($author->profile_photo)
        <img src="{{ asset($author->profile_photo) }}" alt="{{ $author->name }}" class="w-40 h-40 object-cover rounded-full mx-auto mb-4 shadow">
    @endif

    <p class="mb-2">
        <strong>Popular:</strong>
        @if($author->is_popular)
            <span class="text-green-600 font-semibold">Yes</span>
        @else
            <span class="text-gray-500">No</span>
        @endif
    </p>

    <p class="text-sm text-gray-500">
        <strong>Created at:</strong> {{ $author->created_at->format('d M Y, H:i') }} <br>
        <strong>Updated at:</strong> {{ $author->updated_at->format('d M Y, H:i') }}
    </p>

    <div class="mt-6 flex gap-2 justify-center">
        <a href="{{ route('admin.authors.edit', $author) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:opacity-90 transition">
            Edit
        </a>
        <a href="{{ route('admin.authors.index') }}" class="bg-gray-300 text-[#1e293b] px-4 py-2 rounded hover:opacity-80 transition">
            Back
        </a>
    </div>
</div>
@endsection