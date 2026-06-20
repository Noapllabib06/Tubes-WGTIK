<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>FruitPulse AI - @yield('title', 'Dashboard')</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- Konfigurasi Tema Tailwind bawaan dari desain aslimu -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#006e2f",
                        "surface-container-high": "#dee8ff",
                        "on-primary-container": "#004b1e",
                        "on-background": "#111c2d",
                        "on-primary-fixed-variant": "#005321",
                        "primary-container": "#22c55e",
                        "on-primary": "#ffffff",
                        "on-surface-variant": "#3d4a3d",
                        error: "#ba1a1a",
                        surface: "#f9f9ff",
                        "surface-variant": "#d8e3fb",
                        "on-error": "#ffffff",
                        "primary-fixed": "#6bff8f",
                        "on-secondary": "#ffffff",
                        secondary: "#855300",
                        "outline-variant": "#bccbb9",
                        background: "#f9f9ff",
                        "surface-container": "#e7eeff",
                        outline: "#6d7b6c",
                        "surface-container-highest": "#d8e3fb",
                        "on-surface": "#111c2d",
                        "surface-container-low": "#f0f3ff",
                        "surface-container-lowest": "#ffffff",
                    },
                    spacing: {
                        "card-padding": "24px",
                        base: "8px",
                        "container-margin": "24px",
                        "stack-sm": "8px",
                        "stack-md": "16px",
                        gutter: "16px",
                        "stack-lg": "32px"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    <!-- Tambahan CSS untuk spesifik halaman (seperti WebCam) akan diletakkan di sini -->
    @stack('styles')
</head>
<body class="bg-background text-on-surface font-sans">
    
    <!-- SIDEBAR -->
    <aside class="hidden md:flex h-screen w-64 flex-col fixed left-0 top-0 bg-surface-container border-r border-outline-variant p-stack-md z-50">
        <div class="mb-stack-lg">
            <h1 class="text-3xl font-black text-on-primary-container">Fruit Grader</h1>
            <p class="text-xs font-bold tracking-widest text-on-surface-variant uppercase">Precision Grading</p>
        </div>
        <nav class="flex-grow space-y-base">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-highest' }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-xs font-bold uppercase tracking-widest">Dashboard</span>
            </a>
            
            <a href="{{ route('scan') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('scan') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-highest' }}">
                <span class="material-symbols-outlined">videocam</span>
                <span class="text-xs font-bold uppercase tracking-widest">Live Scan</span>
            </a>
            
            <a href="{{ route('history') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('history') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-highest' }}">
                <span class="material-symbols-outlined">history</span>
                <span class="text-xs font-bold uppercase tracking-widest">History</span>
            </a>
            
            <a href="{{ route('setting') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('setting') ? 'bg-primary-container text-on-primary-container' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-highest' }}">
                <span class="material-symbols-outlined">settings</span>
                <span class="text-xs font-bold uppercase tracking-widest">Settings</span>
            </a>
        </nav>
        <div class="pt-stack-md border-t border-outline-variant mt-auto">
            <a class="flex items-center gap-4 px-4 py-3 text-on-surface-variant hover:text-primary transition-all" href="#">
                <span class="material-symbols-outlined">help</span>
                <span class="text-xs font-bold uppercase tracking-widest">Help</span>
            </a>
        </div>
    </aside>

    <!-- AREA UTAMA -->
    <main class="md:ml-64 min-h-screen flex flex-col">
        <!-- HEADER -->
        <header class="bg-surface shadow-sm sticky top-0 z-40">
            <div class="flex justify-between items-center w-full px-container-margin py-base max-w-[1280px] mx-auto">
                <div class="flex items-center gap-base md:hidden">
                    <span class="material-symbols-outlined text-primary">menu</span>
                    <span class="text-2xl font-bold text-primary">FruitPulse</span>
                </div>
                <div class="hidden md:block">
                    <h2 class="text-xl font-semibold text-on-surface">@yield('title')</h2>
                </div>
                <div class="flex items-center gap-stack-md">
                    <!-- Tombol Start System khusus muncul di halaman Scan -->
                    @yield('header-actions')
                    
                    <button class="p-2 rounded-full hover:bg-surface-container-low transition-colors">
                        <span class="material-symbols-outlined text-on-surface-variant">account_circle</span>
                    </button>
                </div>
            </div>
        </header>

        <!-- KONTEN DINAMIS -->
        <div class="max-w-[1280px] mx-auto p-container-margin w-full space-y-stack-lg flex-grow">
            @yield('content')
        </div>
    </main>

    <!-- JavaScript dinamis untuk tiap halaman -->
    @stack('scripts')
</body>
</html>