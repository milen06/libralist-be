<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $webSettings->app_name ?? 'Admin Dashboard' }} | @yield('title')</title>
    
    @vite('resources/css/app.css')

    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single,
        .select2-container .select2-selection--multiple {
            height: auto !important;
            min-height: 42px;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem; /* rounded-md */
            padding: 4px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #e45f65;
            border: none;
            color: white;
            padding: 2px 8px;
            margin-top: 4px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
            margin-right: 4px;
        }

        [x-cloak] { display: none !important; }
    </style>

</head>
<body class="bg-gray-100 text-gray-900">
    @php
        use App\Models\WebSetting;
        $webSettings = WebSetting::first();
    @endphp

    <div class="flex h-screen">
        <!-- SIDEBAR -->
        <aside class="w-64 bg-[#1e293b] text-white flex flex-col fixed h-[100dvh] z-[99]">
            <div class="p-5 flex flex-col items-center border-b border-white/10">
                @if($webSettings && $webSettings->app_logo)
                    <img src="{{ asset($webSettings->app_logo) }}" alt="App Logo" class="w-12 h-12 mb-2 object-cover rounded-full">
                @endif
                <span class="font-bold text-xl">
                    {{ $webSettings->app_name ?? 'Admin Panel' }}
                </span>
            </div>
            <nav class="flex-1 mt-5 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-5 py-3 hover:bg-[#e45f65] transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#e45f65]' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.books.index') }}" class="block px-5 py-3 hover:bg-[#e45f65] transition {{ request()->routeIs('admin.books.*') ? 'bg-[#e45f65]' : '' }}">
                    Books
                </a>
                <a href="{{ route('admin.genres.index') }}" class="block px-5 py-3 hover:bg-[#e45f65] transition {{ request()->routeIs('admin.genres.*') ? 'bg-[#e45f65]' : '' }}">
                    Genres
                </a>
                <a href="{{ route('admin.authors.index') }}" class="block px-5 py-3 hover:bg-[#e45f65] transition {{ request()->routeIs('admin.authors.*') ? 'bg-[#e45f65]' : '' }}">
                    Authors
                </a>
                <a href="{{ route('admin.users.index') }}" class="block px-5 py-3 hover:bg-[#e45f65] transition {{ request()->routeIs('admin.users.*') ? 'bg-[#e45f65]' : '' }}">
                    Users
                </a>
                <a href="{{ route('admin.settings.index') }}" class="block px-5 py-3 hover:bg-[#e45f65] transition {{ request()->routeIs('admin.settings.*') ? 'bg-[#e45f65]' : '' }}">
                    Web Settings
                </a>
            </nav>
            <div class="p-5 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full bg-[#e45f65] py-2 rounded text-white font-semibold hover:opacity-90 transition">Logout</button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 w-[calc(100%-16rem)] ml-64">
            <header class="bg-white shadow p-5 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-[#1e293b]">@yield('page-title')</h1>
            </header>

            <section class="p-6">
                @yield('content')
            </section>
        </main>
    </div>

    <!-- jQuery & Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- TinyMCE untuk Rich Text -->
    <script src="https://cdn.tiny.cloud/1/ahvvagxsl8bhkh0o73flakyp3gboo6v70wbgqxjji71vlpm6/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>


    <!-- Toastify JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- Notifikasi Toast --}}
    @if (session('success'))
        <script>
            Toastify({
            text: "{{ session('success') }}",
            duration: 4000,
            gravity: "top",
            position: "right",
            backgroundColor: "#16a34a", // Tailwind green-600
            stopOnFocus: true,
            }).showToast();
        </script>
    @endif

    @if (session('error'))
        <script>
            Toastify({
            text: "{{ session('error') }}",
            duration: 4000,
            gravity: "top",
            position: "right",
            backgroundColor: "#dc2626", // Tailwind red-600
            stopOnFocus: true,
            }).showToast();
        </script>
    @endif

    @stack('scripts')
</body>
</html>