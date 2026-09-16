@props(['project', 'number' => '01'])
<article class="group panel relative overflow-hidden p-6 sm:p-8">
    <div class="mb-12 flex items-start justify-between"><span class="font-mono text-xs text-slate-500">{{ str_pad($number, 2, '0', STR_PAD_LEFT) }} / {{ strtoupper($project->category->name) }}</span><span class="size-2 bg-cyan"></span></div>
    <p class="mb-3 text-xs font-bold uppercase tracking-[.18em] text-slate-500">{{ $project->eyebrow }}</p>
    <h3 class="text-2xl font-bold tracking-tight sm:text-3xl"><a class="after:absolute after:inset-0" href="{{ route('projects.show', $project) }}">{{ $project->name }}</a></h3>
    <p class="mt-4 leading-7 text-slate-600 dark:text-slate-300">{{ $project->short_description }}</p>
    <div class="mt-8 flex flex-wrap gap-2">@foreach (array_slice($project->technologies ?? [], 0, 4) as $technology)<span class="border border-slate-300 px-2.5 py-1 font-mono text-[10px] uppercase dark:border-slate-700">{{ $technology }}</span>@endforeach</div>
    <div class="mt-8 font-mono text-xs font-medium text-slate-500 transition group-hover:text-cyan">BACA CASE STUDY →</div>
</article>
