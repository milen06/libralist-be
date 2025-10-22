@extends('layouts.admin')

@section('title', 'Edit Genre')
@section('page-title', 'Edit Genre')

@section('content')
<form action="{{ route('admin.genres.update', $genre) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow max-w-lg">
    @csrf
    @method('PUT')

    {{-- Name --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Genre Name</label>
        <input type="text" name="name" value="{{ old('name', $genre->name) }}" class="w-full border rounded p-2">
        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Image --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Image</label>
        <input type="file" name="image" id="imageInput" accept="image/*" class="w-full border rounded p-2">
        @error('image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror

        <div id="imagePreview" class="mt-3">
            @if($genre->image)
                <img src="{{ asset($genre->image) }}" class="w-32 h-32 object-cover rounded shadow">
            @endif
        </div>
    </div>

    <button type="submit" class="bg-[#e45f65] text-white px-4 py-2 rounded hover:opacity-90 transition">
        Update Genre
    </button>
</form>
@endsection

@push('scripts')
<script>
$('#imageInput').on('change', function (e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (event) {
      $('#imagePreview').html(`<img src="${event.target.result}" class="w-32 h-32 object-cover rounded shadow" />`);
    };
    reader.readAsDataURL(file);
  }
});
</script>
@endpush
