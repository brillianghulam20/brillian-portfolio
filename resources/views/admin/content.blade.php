@extends('layouts.admin')
@section('title',ucfirst($type))
@section('content')
@php($labels=['experiences'=>'Experience','educations'=>'Education','skills'=>'Skill','certificates'=>'Certificate','project-categories'=>'Project Category'])
<div class="mb-8"><p class="kicker">Content</p><h1 class="text-3xl font-bold">{{ $labels[$type] }}</h1></div>
<details class="mb-8 max-w-4xl bg-white p-6 shadow-sm" {{ $items->isEmpty()?'open':'' }}><summary class="cursor-pointer font-bold">+ Tambah {{ $labels[$type] }}</summary><form method="POST" action="{{ route('admin.content.store',$type) }}" class="mt-6">@csrf @include('admin.partials.content-fields',['item'=>null])<button class="btn-primary mt-5">Tambahkan</button></form></details>
<div class="grid max-w-4xl gap-4">@foreach($items as $item)<details class="bg-white p-6 shadow-sm"><summary class="flex cursor-pointer items-center justify-between font-bold"><span>{{ $item->position ?? $item->institution ?? $item->name }}</span><span class="font-mono text-xs text-slate-400">EDIT</span></summary><form method="POST" action="{{ route('admin.content.update',[$type,$item->id]) }}" class="mt-6">@csrf @method('PUT') @include('admin.partials.content-fields',['item'=>$item])<button class="btn-primary mt-5">Simpan</button></form><form method="POST" action="{{ route('admin.content.destroy',[$type,$item->id]) }}" class="mt-4" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')<button class="text-xs font-bold text-red-600">Hapus</button></form></details>@endforeach</div>
@endsection
