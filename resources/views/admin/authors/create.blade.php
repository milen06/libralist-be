@extends('layouts.admin')

@section('title', 'Add Author')
@section('page-title', 'Add New Author')

@section('content')
<form action="{{ route('admin.authors.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow max-w-lg">
    @csrf

    {{-- Name --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Author Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Profile Photo --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Profile Photo</label>
        <input type="file" name="profile_photo" id="photoInput" accept="image/*" class="w-full border rounded p-2">
        @error('profile_photo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror

        <div id="photoPreview" class="mt-3"></div>
    </div>

    {{-- Popular --}}
    <div class="mb-4">
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_popular" class="mr-2" {{ old('is_popular') ? 'checked' : '' }}>
            <span>Mark as Popular</span>
        </label>
    </div>

    <button type="submit" class="bg-[#e45f65] text-white px-4 py-2 rounded hover:opacity-90 transition">
        Save Author
    </button>
</form>
@endsection

@push('scripts')
<script>
$('#photoInput').on('change', function (e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (event) {
      $('#photoPreview').html(`<img src="${event.target.result}" class="w-32 h-32 object-cover rounded-full shadow" />`);
    };
    reader.readAsDataURL(file);
  }
});
</script>
@endpush