@extends('layouts.admin')

@section('title', 'User Detail')
@section('page-title', 'User Detail')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-lg">
    <h2 class="text-2xl font-bold mb-4 text-[#1e293b]">{{ $user->name }}</h2>

    <p class="mb-2"><strong>Username:</strong> {{ $user->username }}</p>
    <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
    <p class="mb-2"><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
    <p class="text-sm text-gray-500">
        <strong>Created at:</strong> {{ $user->created_at->format('d M Y, H:i') }} <br>
        <strong>Updated at:</strong> {{ $user->updated_at->format('d M Y, H:i') }}
    </p>

    <div class="mt-6 flex gap-2">
        <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:opacity-90 transition">
            Edit
        </a>
        <a href="{{ route('admin.users.index') }}" class="bg-gray-300 text-[#1e293b] px-4 py-2 rounded hover:opacity-80 transition">
            Back
        </a>
    </div>
</div>
@endsection