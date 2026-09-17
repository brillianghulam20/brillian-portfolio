<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') · Brillian Portfolio</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-100 dark:bg-ink">
<div x-data="{nav:false}" class="min-h-screen lg:grid lg:grid-cols-[250px_1fr]">
    <div x-cloak x-show="nav" @click="nav=false" class="fixed inset-0 z-30 bg-black/50 lg:hidden"></div>
    <aside :class="nav?'block':'hidden'" class="fixed inset-y-0 left-0 z-40 w-[280px] max-w-[85vw] overflow-y-auto bg-ink p-6 text-white lg:static lg:block lg:w-[250px] lg:max-w-none">
        <div class="flex items-center justify-between"><a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 font-bold"><span class="grid size-9 place-items-center rounded-lg bg-cyan font-mono text-xs text-white">BG</span>Portfolio CMS</a><button @click="nav=false" class="grid size-9 place-items-center rounded-lg border border-white/15 lg:hidden" aria-label="Tutup menu">×</button></div>
        <nav class="mt-10 grid gap-1 text-sm">
            @foreach (['admin.dashboard'=>'Dashboard','admin.profile.edit'=>'Profile','admin.projects.index'=>'Projects'] as $route=>$label)
                <a href="{{ route($route) }}" class="px-3 py-2.5 hover:bg-white/10 {{ request()->routeIs($route) ? 'bg-white/10 text-cyan' : '' }}">{{ $label }}</a>
            @endforeach
            <p class="mb-1 mt-6 px-3 font-mono text-[10px] text-slate-500">CONTENT</p>
            @foreach (['experiences'=>'Experience','educations'=>'Education','skills'=>'Skills','certificates'=>'Certificates','project-categories'=>'Project Categories'] as $type=>$label)
                <a href="{{ route('admin.content.index',$type) }}" class="px-3 py-2.5 hover:bg-white/10">{{ $label }}</a>
            @endforeach
        </nav>
        <div class="mt-12 lg:absolute lg:bottom-6 lg:left-6 lg:right-6">
            <a class="mb-3 block text-xs text-slate-400 hover:text-cyan" href="{{ route('home') }}" target="_blank">Lihat website ↗</a>
            <form method="POST" action="{{ route('admin.logout') }}">@csrf<button class="w-full border border-slate-700 px-3 py-2 text-left text-xs hover:border-cyan">Logout</button></form>
        </div>
    </aside>
    <main>
        <header class="flex h-16 items-center justify-between gap-3 border-b border-slate-200 bg-white px-4 sm:px-5 lg:px-8"><button @click="nav=!nav" class="rounded-lg border border-slate-200 px-3 py-2 font-mono text-xs lg:hidden">MENU</button><p class="hidden font-mono text-xs text-slate-500 sm:block">CONTENT MANAGEMENT SYSTEM</p><p class="max-w-36 truncate text-sm font-bold sm:max-w-none">{{ auth()->user()->name }}</p></header>
        <div class="p-5 lg:p-8">
            @if(session('status'))<div class="mb-6 border border-emerald-300 bg-emerald-50 p-4 text-sm text-emerald-800">{{ session('status') }}</div>@endif
            @if($errors->any())<div class="mb-6 border border-red-300 bg-red-50 p-4 text-sm text-red-800"><strong>Periksa kembali data:</strong><ul class="mt-2 list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
