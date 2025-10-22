@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="grid md:grid-cols-4 gap-6">
    <div class="bg-white shadow rounded-lg p-5 text-center">
        <h2 class="text-gray-500">Total Books</h2>
        <p class="text-3xl font-bold text-[#e45f65]">{{ $totalBooks ?? 0 }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-5 text-center">
        <h2 class="text-gray-500">Genres</h2>
        <p class="text-3xl font-bold text-[#e45f65]">{{ $totalGenres ?? 0 }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-5 text-center">
        <h2 class="text-gray-500">Authors</h2>
        <p class="text-3xl font-bold text-[#e45f65]">{{ $totalAuthors ?? 0 }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-5 text-center">
        <h2 class="text-gray-500">Users</h2>
        <p class="text-3xl font-bold text-[#e45f65]">{{ $totalUsers ?? 0 }}</p>
    </div>
</div>

<div class="mt-10 bg-white shadow rounded-lg p-6">
    <h3 class="text-lg font-bold mb-4">Recent Activity</h3>
    <ul class="divide-y">
        <li class="py-2 text-gray-700">Recent activity...</li>
    </ul>
</div>
@endsection