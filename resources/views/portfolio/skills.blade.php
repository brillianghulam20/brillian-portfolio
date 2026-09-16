@extends('layouts.app')
@section('title', 'Keahlian | Brillian Ghulam')
@section('content')
<section class="section shell"><p class="kicker">Skills / Capability Map</p><h1 class="display">Bukan skor. Kompetensi yang digunakan dalam konteks.</h1><div class="mt-16 grid gap-5 md:grid-cols-2">@foreach ($skillCategories as $category)<article class="panel p-7 sm:p-9"><span class="font-mono text-xs text-cyan">0{{ $loop->iteration }}</span><h2 class="mt-6 text-2xl font-bold">{{ $category->name }}</h2><div class="mt-8 flex flex-wrap gap-2">@foreach ($category->skills as $skill)<span class="border border-slate-300 px-3 py-2 text-sm dark:border-slate-700">{{ $skill->name }}</span>@endforeach</div></article>@endforeach</div></section>
@endsection
