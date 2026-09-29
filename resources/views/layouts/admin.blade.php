<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | BookStore Admin Panel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-[#0b1329] text-slate-100 font-['Inter'] min-h-screen">

    {{-- Admin Sidebar --}}
    @include('components.admin.sidebar')

    {{-- Main Content Area --}}
    <div class="pl-64 flex flex-col min-h-screen">

        {{-- Admin Topbar --}}
        <header class="fixed top-0 left-64 right-0 h-16 bg-[#0f172a]/95 backdrop-blur-xl border-b border-slate-800 z-40 px-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h2 class="text-slate-100 font-semibold text-lg">@yield('page_title', 'Dashboard')</h2>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-amber-500/20 flex items-center justify-center text-amber-400 font-bold text-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="hidden md:flex flex-col">
                        <span class="text-slate-200 font-semibold text-sm leading-tight">{{ auth()->user()->name }}</span>
                        <span class="text-amber-400 text-xs leading-tight">Administrator</span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-slate-400 hover:text-red-400 hover:bg-slate-800 text-sm transition-colors">
                        <span class="material-symbols-outlined text-[18px]">logout</span>
                        <span class="hidden md:inline">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="fixed top-20 right-4 z-[100] flex flex-col gap-2" id="flash-container">
            @if(session('success'))
                <div class="flash-msg max-w-sm bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 px-5 py-3 rounded-xl shadow-lg flex items-center gap-3">
                    <span class="material-symbols-outlined text-emerald-400">check_circle</span>
                    <span class="text-sm">{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-500 hover:text-emerald-300">
                        <span class="material-symbols-outlined text-base">close</span>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="flash-msg max-w-sm bg-red-500/10 border border-red-500/30 text-red-300 px-5 py-3 rounded-xl shadow-lg flex items-center gap-3">
                    <span class="material-symbols-outlined text-red-400">error</span>
                    <span class="text-sm">{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-red-500 hover:text-red-300">
                        <span class="material-symbols-outlined text-base">close</span>
                    </button>
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <main class="pt-16 flex-1 w-full">
            <div class="max-w-[1600px] mx-auto px-6 lg:px-8 py-8">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        setTimeout(() => {
            document.querySelectorAll('.flash-msg').forEach(el => {
                el.style.transition = 'opacity 0.3s ease';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 300);
            });
        }, 4000);
    </script>

    @stack('scripts')
</body>
</html>
