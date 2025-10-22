@extends('layouts.auth')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
    <h1 class="text-2xl font-bold text-center mb-6 text-[#1e293b]">Admin Login</h1>

    @if ($errors->any())
      <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if (session('success'))
      <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf

      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}"
          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#e45f65]">
      </div>

      <div class="mb-4">
        <label for="password" class="block text-gray-700 font-semibold mb-1">Password</label>
        <input type="password" name="password" id="password"
          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#e45f65]">
      </div>

      <div class="flex items-center justify-between mb-6">
        <label class="inline-flex items-center">
          <input type="checkbox" name="remember" class="rounded text-[#e45f65] focus:ring-[#e45f65]">
          <span class="ml-2 text-gray-600">Remember me</span>
        </label>
        {{-- Bisa ditambahkan link "Forgot password" jika perlu --}}
      </div>

      <button type="submit"
        class="w-full bg-[#e45f65] hover:opacity-90 text-white font-semibold py-2 rounded transition">
        Login
      </button>
    </form>
  </div>
@endsection