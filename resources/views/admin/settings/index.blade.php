@extends('layouts.admin')

@section('title', 'Web Settings')
@section('page-title', 'Web Settings')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-2xl">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- App Name --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Application Name</label>
            <input type="text" name="app_name" value="{{ old('app_name', $settings->app_name) }}" class="w-full border rounded p-2">
            @error('app_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- App Description --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Application Description</label>
            <textarea name="app_description" rows="3" class="w-full border rounded p-2">{{ old('app_description', $settings->app_description) }}</textarea>
            @error('app_description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- App Logo --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Application Logo</label>
            <input type="file" name="app_logo" id="logoInput" accept="image/*" class="w-full border rounded p-2">
            @error('app_logo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror

            <div id="logoPreview" class="mt-3">
                @if($settings->app_logo)
                    <img src="{{ asset($settings->app_logo) }}" alt="App Logo" class="w-24 h-24 object-cover rounded shadow">
                @endif
            </div>
        </div>

        {{-- Total Visitors (read only) --}}
        <div class="mb-6">
            <label class="block font-semibold mb-1">Total Visitors</label>
            <input type="text" readonly value="{{ $settings->total_visitors }}" class="w-full border rounded p-2 bg-gray-100 text-gray-600">
        </div>

        <button type="submit" class="bg-[#e45f65] text-white px-4 py-2 rounded hover:opacity-90 transition">
            Save Settings
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
$('#logoInput').on('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (event) {
            $('#logoPreview').html(`<img src="${event.target.result}" class="w-24 h-24 object-cover rounded shadow" />`);
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush