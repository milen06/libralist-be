@extends('layouts.admin')

@section('title', 'Users')
@section('page-title', 'Visitor Users')

@section('content')
<div class="flex justify-between mb-5">
    <h2 class="text-lg font-bold text-[#1e293b]">All Visitor Users</h2>
    <a href="{{ route('admin.users.create') }}" class="bg-[#e45f65] text-white px-4 py-2 rounded hover:opacity-90 transition">
        + Add User
    </a>
</div>

<div x-data="{ open: false, deleteUrl: '' }">
    <!-- Modal Delete -->
    <div x-show="open" x-cloak class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div @click.away="open = false" class="bg-white p-6 rounded-lg shadow max-w-sm w-full">
            <h3 class="text-lg font-bold mb-3 text-[#1e293b]">Delete Confirmation</h3>
            <p class="text-gray-600 mb-5">Are you sure you want to delete this user?</p>
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

    <!-- Table -->
    <table class="min-w-full bg-white rounded-lg shadow overflow-hidden">
        <thead class="bg-[#1e293b] text-white">
            <tr>
                <th class="px-4 py-2 text-left">#</th>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Username</th>
                <th class="px-4 py-2 text-left">Email</th>
                <th class="px-4 py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($users as $user)
            <tr>
                <td class="px-4 py-2">{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                <td class="px-4 py-2 font-medium">{{ $user->name }}</td>
                <td class="px-4 py-2">{{ $user->username }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2 text-center space-x-2">
                    <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:underline">Detail</a>
                    <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-600 hover:underline">Edit</a>
                    <button @click="open = true; deleteUrl='{{ route('admin.users.destroy', $user) }}'" class="text-red-600 hover:underline">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection