<!DOCTYPE html>
<html lang="id" x-data="{ menu: false, theme: localStorage.theme || 'light' }" x-init="$watch('theme', value => { localStorage.theme = value; document.documentElement.classList.toggle('dark', value === 'dark' || (value === 'system' && matchMedia('(prefers-color-scheme: dark)').matches)) })" :class="{ 'dark': theme === 'dark' || (theme === 'system' && matchMedia('(prefers-color-scheme: dark)').matches) }">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', ($profile?->name ?? 'Brillian Ghulam').' | System Analyst')</title>
    <meta name="description" content="@yield('description', 'Portfolio Brillian Ghulam, System Analyst dan ERP Implementor.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website"><meta property="og:title" content="@yield('title', $profile?->name ?? 'Brillian Ghulam')"><meta property="og:description" content="@yield('description', $profile?->tagline ?? '')"><meta property="og:url" content="{{ url()->current() }}">
    @if($profile?->photo_path)<meta property="og:image" content="{{ request()->root().'/storage/'.ltrim($profile->photo_path, '/') }}"><meta property="og:image:alt" content="Foto {{ $profile->name }}">@endif
    <meta name="twitter:card" content="summary_large_image">
    <script>document.documentElement.classList.toggle('dark',localStorage.theme==='dark'||(localStorage.theme==='system'&&matchMedia('(prefers-color-scheme:dark)').matches))</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>
<a href="#content" class="fixed left-4 top-4 z-[100] -translate-y-24 rounded bg-cyan px-4 py-2 font-bold text-white focus:translate-y-0">Lewati ke konten</a>
<div class="no-print hidden bg-ink text-white lg:block">
    <div class="shell flex h-11 items-center justify-between text-xs">
        <div class="flex items-center gap-7 text-slate-300"><a class="hover:text-cyan" href="mailto:{{ $profile?->email }}">✉ {{ $profile?->email }}</a><span>◷ Senin - Jumat, 08.00 - 17.00</span></div>
        <div class="flex items-center gap-5"><a class="hover:text-cyan" href="{{ route('projects.index') }}">Case Studies</a><a class="hover:text-cyan" href="{{ route('contact') }}">Kontak</a><a class="hover:text-cyan" href="{{ $profile?->linkedin_url }}" target="_blank" rel="noopener">LinkedIn ↗</a></div>
    </div>
</div>
<header class="no-print sticky top-0 z-50 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur dark:border-slate-800 dark:bg-ink/95">
    <div class="shell flex h-16 items-center justify-between sm:h-20">
        <a href="{{ route('home') }}" class="flex items-center gap-3"><span class="grid size-11 place-items-center rounded-lg bg-cyan text-sm font-extrabold text-white">BG</span><span><strong class="block text-base leading-none">Brillian Ghulam</strong><small class="mt-1 block text-[10px] font-bold uppercase tracking-[.14em] text-slate-400">System Analyst</small></span></a>
        <nav class="hidden items-center gap-8 text-sm font-bold lg:flex" aria-label="Navigasi utama">
            @foreach (['home' => 'Home', 'about' => 'Tentang', 'experience' => 'Pengalaman', 'skills' => 'Keahlian', 'projects.index' => 'Project', 'resume' => 'Resume'] as $route => $label)<a href="{{ route($route) }}" class="relative py-7 transition after:absolute after:inset-x-0 after:bottom-4 after:h-0.5 after:origin-left after:scale-x-0 after:bg-cyan after:transition hover:text-cyan hover:after:scale-x-100 {{ request()->routeIs($route) ? 'text-cyan after:scale-x-100' : '' }}">{{ $label }}</a>@endforeach
        </nav>
        <div class="flex items-center gap-2">
            <button @click="theme = theme === 'dark' ? 'light' : 'dark'" class="grid size-11 place-items-center rounded-lg border border-slate-200 text-lg dark:border-slate-700" aria-label="Ganti tema"><span x-text="theme === 'dark' ? '☀' : '◐'"></span></button>
            <a class="btn-primary hidden py-3 lg:inline-flex" href="{{ route('contact') }}">Hubungi Saya <span>↗</span></a>
            <button @click="menu = !menu" class="grid size-11 place-items-center rounded-lg bg-ink text-xs font-bold text-white lg:hidden" :aria-expanded="menu"><span class="sr-only">Buka menu</span>MENU</button>
        </div>
    </div>
    <nav x-cloak x-show="menu" @click.outside="menu=false" class="shell grid gap-1 border-t border-slate-200 py-4 lg:hidden dark:border-slate-800">
        @foreach (['home' => 'Home', 'about' => 'Tentang', 'experience' => 'Pengalaman', 'skills' => 'Keahlian', 'projects.index' => 'Project', 'resume' => 'Resume', 'contact' => 'Kontak'] as $route => $label)<a @click="menu=false" href="{{ route($route) }}" class="rounded-lg px-4 py-3 font-semibold hover:bg-orange-50 hover:text-cyan dark:hover:bg-white/5">{{ $label }}</a>@endforeach
    </nav>
</header>
<main id="content">@yield('content')</main>
<section class="no-print bg-cyan text-white"><div class="shell flex flex-col justify-between gap-8 py-12 lg:flex-row lg:items-center"><div><p class="text-xs font-bold uppercase tracking-[.18em] text-white/70">Mari berkolaborasi</p><h2 class="mt-3 text-3xl font-extrabold tracking-tight sm:text-4xl">Punya tantangan proses atau sistem?</h2></div><a class="inline-flex w-fit items-center gap-3 rounded-lg bg-white px-6 py-4 text-sm font-bold text-ink transition hover:-translate-y-1" href="{{ route('contact') }}">Mulai percakapan <span>→</span></a></div></section>
<footer class="no-print bg-ink pt-16 text-white"><div class="shell grid gap-12 pb-14 md:grid-cols-2 lg:grid-cols-[1.4fr_.7fr_.7fr_1fr]"><div><a href="{{ route('home') }}" class="flex items-center gap-3"><span class="grid size-11 place-items-center rounded-lg bg-cyan font-extrabold">BG</span><strong class="text-xl">Brillian Ghulam</strong></a><p class="mt-6 max-w-sm text-sm leading-7 text-slate-400">Menerjemahkan kebutuhan bisnis menjadi proses, sistem, dan solusi teknologi yang terukur.</p><div class="mt-7 flex gap-3"><a class="grid size-10 place-items-center rounded-lg border border-white/15 hover:border-cyan hover:text-cyan" href="{{ $profile?->linkedin_url }}">in</a><a class="grid size-10 place-items-center rounded-lg border border-white/15 hover:border-cyan hover:text-cyan" href="mailto:{{ $profile?->email }}">@</a></div></div><div><h3 class="font-bold">Navigasi</h3><div class="mt-5 grid gap-3 text-sm text-slate-400"><a href="{{ route('about') }}">Tentang</a><a href="{{ route('experience') }}">Pengalaman</a><a href="{{ route('skills') }}">Keahlian</a><a href="{{ route('resume') }}">Resume</a></div></div><div><h3 class="font-bold">Portfolio</h3><div class="mt-5 grid gap-3 text-sm text-slate-400"><a href="{{ route('projects.index') }}">Semua Project</a><a href="{{ route('projects.index') }}">Case Study</a><a href="{{ route('resume.download') }}">Download CV</a><a href="{{ route('contact') }}">Kontak</a></div></div><div><h3 class="font-bold">Hubungi Saya</h3><div class="mt-5 space-y-4 text-sm text-slate-400"><p>{{ $profile?->phone }}</p><a class="block break-all" href="mailto:{{ $profile?->email }}">{{ $profile?->email }}</a><p>{{ $profile?->location }}</p></div></div></div><div class="border-t border-white/10"><div class="shell flex flex-col justify-between gap-3 py-6 text-xs text-slate-500 sm:flex-row"><p>© {{ date('Y') }} Brillian Ghulam. All rights reserved.</p><p>System Analysis · ERP · Development · Data</p></div></div></footer>
</body></html>
