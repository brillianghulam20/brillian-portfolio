{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ([route('home'), route('about'), route('experience'), route('skills'), route('projects.index'), route('resume'), route('contact')] as $url)
    <url><loc>{{ $url }}</loc></url>
@endforeach
@foreach ($projects as $project)
    <url><loc>{{ route('projects.show', $project) }}</loc><lastmod>{{ $project->updated_at->toAtomString() }}</lastmod></url>
@endforeach
</urlset>
