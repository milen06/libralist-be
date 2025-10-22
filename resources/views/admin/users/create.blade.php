@extends('layouts.admin')

@section('title', 'Add User')
@section('page-title', 'Add New Visitor User')

@section('content')
<form action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow max-w-lg">
    @csrf

    <div class="mb-4">
        <label class="block font-semibold mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Username</label>
        <input type="text" name="username" value="{{ old('username') }}" class="w-full border rounded p-2">
        @error('username') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2">
        @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Password</label>
        <input type="password" name="password" class="w-full border rounded p-2">
        @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="bg-[#e45f65] text-white px-4 py-2 rounded hover:opacity-90 transition">
        Save User
    </button>
</form>
@endsection