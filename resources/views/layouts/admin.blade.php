<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Back-office') — Havre de Paix Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="antialiased" style="font-family: var(--font-sans); background-color: #f1f5f9;">

<div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

    {{-- Overlay mobile --}}
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black/50 lg:hidden" style="display: none;"></div>

    {{-- Sidebar (fixe sur mobile, statique sur desktop) --}}
    <aside class="fixed inset-y-0 left-0 z-50 flex flex-col w-64 shrink-0 shadow-lg transform transition-transform duration-200 lg:static lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           style="background-color: var(--color-navy);">
        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 h-16 border-b" style="border-color: rgba(255,255,255,0.1);">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm" style="background-color: var(--color-orange);">HDP</div>
            <div>
                <div class="text-white font-semibold text-sm" style="font-family: var(--font-serif);">Havre de Paix</div>
                <div class="text-xs" style="color: rgba(255,255,255,0.5);">Back-office</div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
            @php
            $navItems = [
                ['route' => 'admin.dashboard', 'label' => 'Tableau de bord', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                ['route' => 'admin.reservations.index', 'label' => 'Réservations', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                ['route' => 'admin.rooms.index', 'label' => 'Chambres', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                ['route' => 'admin.pricing.index', 'label' => 'Tarifs', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
            ];
            @endphp

            @foreach ($navItems as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs($item['route']) ? 'text-white' : 'hover:bg-white/10' }}"
               style="{{ request()->routeIs($item['route']) ? 'background-color: var(--color-orange);' : 'color: rgba(255,255,255,0.7);' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
                {{ $item['label'] }}
            </a>
            @endforeach
        </nav>

        {{-- User info --}}
        <div class="px-4 py-4 border-t" style="border-color: rgba(255,255,255,0.1);">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background-color: var(--color-blue);">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-white text-sm font-medium truncate">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="text-xs truncate" style="color: rgba(255,255,255,0.5);">{{ auth()->user()->role ?? 'admin' }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-1.5 rounded transition-colors hover:bg-white/10" style="color: rgba(255,255,255,0.5);" title="Déconnexion">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Top bar --}}
        <header class="bg-white border-b h-16 flex items-center justify-between px-4 sm:px-6 shrink-0" style="border-color: var(--color-border);">
            <div class="flex items-center gap-2">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 rounded-lg cursor-pointer transition-colors hover:bg-slate-100" style="color: var(--color-navy);" aria-label="Ouvrir le menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-bold tracking-tight" style="color: var(--color-navy);">@yield('page-title', 'Tableau de bord')</h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="text-sm flex items-center gap-1.5 transition-colors" style="color: var(--color-slate);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Voir le site
                </a>
            </div>
        </header>

        {{-- Flash messages --}}
        @if (session('success'))
        <div class="mx-6 mt-4 px-4 py-3 rounded-lg text-sm font-medium text-green-800 bg-green-50 border border-green-200 flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@stack('scripts')
</body>
</html>
