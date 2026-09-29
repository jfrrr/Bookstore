<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'BookStore — Temukan buku favorit Anda. Koleksi lengkap buku fiksi, teknologi, bisnis, dan pengembangan diri.')">
    <title>@yield('title', 'BookStore') | Discover Your Next Great Read</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-[#fff8f5] text-[#1f1b17] font-['Inter'] min-h-screen">

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="flash-success" class="fixed top-20 right-4 z-[100] max-w-sm bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-xl shadow-lg flex items-center gap-3 animate-fade-in">
            <span class="material-symbols-outlined text-emerald-600">check_circle</span>
            <span class="text-sm font-medium">{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-500 hover:text-emerald-700">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div id="flash-error" class="fixed top-20 right-4 z-[100] max-w-sm bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl shadow-lg flex items-center gap-3">
            <span class="material-symbols-outlined text-red-600">error</span>
            <span class="text-sm font-medium">{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    @endif

    {{-- Main Content --}}
    <main class="pt-16">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    <script>
        // Auto-dismiss flash messages after 4 seconds
        setTimeout(() => {
            document.querySelectorAll('#flash-success, #flash-error').forEach(el => {
                el.style.transition = 'opacity 0.3s ease';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 300);
            });
        }, 4000);
    </script>

    @stack('scripts')
</body>
</html>
