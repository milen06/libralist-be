@extends('layouts.admin')

@section('title', 'Add Book')
@section('page-title', 'Add New Book')

@section('content')
<form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow max-w-3xl">
    @csrf

    {{-- Title --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Title</label>
        <input type="text" id="titleInput" name="title" value="{{ old('title') }}" class="w-full border rounded p-2">
        @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Slug --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Slug</label>
        <input type="text" id="slugInput" name="slug" value="{{ old('slug') }}" class="w-full border rounded p-2">
        @error('slug') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Author --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Author</label>
        <select name="author_id" id="authorSelect" class="w-full">
            <option value="">-- Choose Author --</option>
            @foreach($authors as $author)
                <option value="{{ $author->id }}">{{ $author->name }}</option>
            @endforeach
        </select>
        @error('author_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Genres --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Genres</label>
        <select name="genres[]" id="genreSelect" class="w-full" multiple>
            @foreach($genres as $genre)
                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
            @endforeach
        </select>
        @error('genres') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Short Desc --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Short Description</label>
        <textarea name="short_desc" rows="3" class="w-full border rounded p-2">{{ old('short_desc') }}</textarea>
        @error('short_desc') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Synopsis - Rich Text --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Synopsis</label>
        <textarea name="synopsis" id="synopsisEditor" class="w-full border rounded p-2">{{ old('synopsis') }}</textarea>
        @error('synopsis') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Published At --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Published At</label>
        <input type="date" name="published_at" value="{{ old('published_at') }}" class="w-full border rounded p-2">
        @error('published_at') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Languages (Multiple Select) --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Languages</label>
        <select name="languages[]" id="languagesSelect" class="w-full" multiple>
            @foreach(['English', 'Indonesian', 'Japanese', 'Korean', 'Chinese'] as $lang)
                <option value="{{ $lang }}">{{ $lang }}</option>
            @endforeach
        </select>
        @error('languages') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Image Upload + Preview --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Book Image</label>
        <input type="file" name="image" id="imageInput" accept="image/*" class="w-full border rounded p-2">
        @error('image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror

        <div id="imagePreview" class="mt-3"></div>
    </div>

    <button type="submit" class="bg-[#e45f65] text-white px-4 py-2 rounded hover:opacity-90 transition">
        Save Book
    </button>
</form>
@endsection

@push('scripts')
<script>
tinymce.init({
  selector: '#synopsisEditor',
  height: 300,
  menubar: false,
  plugins: 'link lists code',
  toolbar: 'undo redo | bold italic | bullist numlist | link | code',
  branding: false
});

// Slug otomatis dari Title
$('#titleInput').on('input', function() {
  const slug = $(this).val().toLowerCase().trim().replace(/\s+/g, '-').replace(/[^a-z0-9\-]/g, '');
  $('#slugInput').val(slug);
});

// Image preview
$('#imageInput').on('change', function (e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (event) {
      $('#imagePreview').html(`<img src="${event.target.result}" class="w-48 rounded shadow" />`);
    };
    reader.readAsDataURL(file);
  }
});

// Select2 init
$('#authorSelect').select2({ placeholder: 'Select Author', allowClear: true, width: '100%' });
$('#genreSelect').select2({ placeholder: 'Select Genres', allowClear: true, width: '100%' });
$('#languagesSelect').select2({ placeholder: 'Select Languages', allowClear: true, width: '100%' });
</script>
@endpush