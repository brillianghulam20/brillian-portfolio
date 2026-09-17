@props(['project', 'number' => '01'])
@php($coverImage = $project->thumbnail_path ?: (($project->gallery ?? [])[0] ?? null))
<article class="group panel relative flex h-full flex-col overflow-hidden transition duration-300 hover:-translate-y-2">
    <div class="relative flex min-h-56 items-end overflow-hidden bg-ink text-white sm:min-h-64">
        @if($coverImage)
            <img class="absolute inset-0 size-full object-cover transition duration-700 group-hover:scale-105" src="{{ '/storage/'.ltrim($coverImage, '/') }}" alt="Tampilan {{ $project->name }}" loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/15 to-transparent"></div>
        @else
            <div class="absolute -right-10 -top-10 size-40 rounded-full border border-white/10 transition duration-500 group-hover:scale-125"></div><div class="absolute right-10 top-8 size-20 rounded-full bg-cyan/20 blur-2xl"></div>
        @endif
        <span class="absolute left-5 top-5 rounded-full bg-ink/70 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-white backdrop-blur sm:left-6 sm:top-6">{{ $project->category->name }}</span>
        <span class="relative p-6 text-5xl font-extrabold text-white/70 drop-shadow sm:p-7 sm:text-6xl">{{ str_pad($number, 2, '0', STR_PAD_LEFT) }}</span>
    </div>
    <div class="relative flex flex-1 flex-col p-5 sm:p-7"><div class="absolute inset-x-0 top-0 h-1 origin-left scale-x-0 bg-cyan transition duration-300 group-hover:scale-x-100"></div><p class="text-[10px] font-bold uppercase tracking-[.14em] text-cyan sm:text-xs">{{ $project->eyebrow }}</p><h3 class="mt-3 break-words text-xl font-extrabold tracking-tight sm:text-2xl"><a class="after:absolute after:inset-0" href="{{ route('projects.show', $project) }}">{{ $project->name }}</a></h3><p class="mt-4 flex-1 text-sm leading-7 text-slate-500 sm:text-base dark:text-slate-300">{{ $project->short_description }}</p><div class="mt-6 flex flex-wrap gap-2">@foreach (array_slice($project->technologies ?? [], 0, 3) as $technology)<span class="rounded-full bg-slate-100 px-3 py-1.5 text-[10px] font-bold uppercase text-slate-500 dark:bg-white/10 dark:text-slate-300">{{ $technology }}</span>@endforeach</div><div class="mt-7 flex items-center gap-2 text-sm font-bold text-cyan">Lihat case study <span class="transition group-hover:translate-x-1">→</span></div></div>
</article>
