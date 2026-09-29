<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BookStore') | BookStore</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#fff8f5] text-[#1f1b17] font-['Inter'] min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5">
                <span class="material-symbols-outlined text-[#8d4b00] text-4xl" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                <span class="font-['Playfair_Display'] font-bold text-2xl text-[#8d4b00] tracking-tight">BookStore</span>
            </a>
            <p class="mt-2 text-[#554336] text-sm">Discover Your Next Great Read</p>
        </div>

        @yield('content')

        <p class="text-center text-sm text-[#887364] mt-6">
            &copy; {{ date('Y') }} BookStore. All rights reserved.
        </p>
    </div>

    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>
