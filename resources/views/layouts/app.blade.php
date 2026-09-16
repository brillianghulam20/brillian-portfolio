<!DOCTYPE html>
<html lang="id" x-data="{ menu: false, theme: localStorage.theme || 'system' }" x-init="$watch('theme', value => { localStorage.theme = value; document.documentElement.classList.toggle('dark', value === 'dark' || (value === 'system' && matchMedia('(prefers-color-scheme: dark)').matches)) })" :class="{ 'dark': theme === 'dark' || (theme === 'system' && matchMedia('(prefers-color-scheme: dark)').matches) }">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', ($profile?->name ?? 'Brillian Ghulam').' | System Analyst')</title>
    <meta name="description" content="@yield('description', 'Portfolio Brillian Ghulam, System Analyst dan ERP Implementor.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website"><meta property="og:title" content="@yield('title', $profile?->name ?? 'Brillian Ghulam')"><meta property="og:description" content="@yield('description', $profile?->tagline ?? '')"><meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <script>document.documentElement.classList.toggle('dark',localStorage.theme==='dark'||((!localStorage.theme||localStorage.theme==='system')&&matchMedia('(prefers-color-scheme:dark)').matches))</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>
<a href="#content" class="fixed left-4 top-4 z-[100] -translate-y-24 bg-cyan px-4 py-2 font-bold text-ink focus:translate-y-0">Lewati ke konten</a>
<header class="no-print sticky top-0 z-50 border-b border-slate-300/70 bg-paper/90 backdrop-blur dark:border-slate-800 dark:bg-ink/90">
    <div class="shell flex h-18 items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3 font-bold tracking-tight"><span class="grid size-9 place-items-center bg-ink font-mono text-xs text-cyan dark:bg-cyan dark:text-ink">BG</span><span class="hidden sm:block">Brillian Ghulam</span></a>
        <nav class="hidden items-center gap-7 text-sm font-semibold lg:flex" aria-label="Navigasi utama">
            @foreach (['about' => 'Tentang', 'experience' => 'Pengalaman', 'skills' => 'Keahlian', 'projects.index' => 'Project', 'resume' => 'Resume', 'contact' => 'Kontak'] as $route => $label)<a href="{{ route($route) }}" class="transition hover:text-cyan {{ request()->routeIs($route) ? 'text-cyan' : '' }}">{{ $label }}</a>@endforeach
        </nav>
        <div class="flex items-center gap-2">
            <select x-model="theme" aria-label="Tema" class="border border-slate-300 bg-transparent px-2 py-2 text-xs dark:border-slate-700"><option value="system">System</option><option value="light">Light</option><option value="dark">Dark</option></select>
            <button @click="menu = !menu" class="grid size-10 place-items-center border border-slate-300 lg:hidden dark:border-slate-700" :aria-expanded="menu"><span class="sr-only">Buka menu</span><span class="font-mono">MENU</span></button>
        </div>
    </div>
    <nav x-cloak x-show="menu" @click.outside="menu=false" class="shell grid gap-1 border-t border-slate-300 py-4 lg:hidden dark:border-slate-800">
        @foreach (['home' => 'Home', 'about' => 'Tentang', 'experience' => 'Pengalaman', 'skills' => 'Keahlian', 'projects.index' => 'Project', 'resume' => 'Resume', 'contact' => 'Kontak'] as $route => $label)<a @click="menu=false" href="{{ route($route) }}" class="px-3 py-3 font-semibold hover:bg-cyan hover:text-ink">{{ $label }}</a>@endforeach
    </nav>
</header>
<main id="content">@yield('content')</main>
<footer class="no-print border-t border-slate-300 py-10 dark:border-slate-800"><div class="shell flex flex-col justify-between gap-5 sm:flex-row"><div><p class="font-bold">Brillian Ghulam Ash Shidiq</p><p class="mt-1 text-sm text-slate-500">System Analyst · ERP Implementor · Developer</p></div><p class="font-mono text-xs text-slate-500">© {{ date('Y') }} · BUILT TO EXPLAIN THE WORK</p></div></footer>
</body></html>
