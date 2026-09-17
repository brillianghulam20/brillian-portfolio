@extends('layouts.app')
@section('title', 'Kontak | Brillian Ghulam')
@section('description', 'Hubungi Brillian Ghulam untuk diskusi mengenai system analysis, ERP implementation, web development, data, dan automation.')
@section('content')
<section class="page-hero">
    <div class="shell relative z-10 text-center"><p class="text-sm font-semibold text-orange-300">Home <span class="mx-2 text-white/30">/</span> Contact</p><h1 class="mt-5 text-4xl font-extrabold tracking-[-.04em] sm:text-6xl">Hubungi Saya</h1><p class="mx-auto mt-5 max-w-2xl text-sm leading-7 text-slate-300 sm:text-base">Mari diskusikan kebutuhan, tantangan proses, atau peluang kolaborasi yang dapat kita ubah menjadi solusi nyata.</p></div>
</section>
<section class="relative z-10 -mt-10 pb-20 sm:pb-28">
    <div class="shell">
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            <a class="panel group flex min-w-0 items-center gap-4 p-5 transition hover:-translate-y-1 sm:gap-5 sm:p-6" href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener"><span class="icon-box text-2xl">☎</span><span class="min-w-0"><small class="font-bold text-slate-400">Hubungi langsung</small><strong class="mt-1 block break-words group-hover:text-cyan">{{ $profile->phone }}</strong></span></a>
            <a class="panel group flex min-w-0 items-center gap-4 p-5 transition hover:-translate-y-1 sm:gap-5 sm:p-6" href="mailto:{{ $profile->email }}"><span class="icon-box text-2xl">✉</span><span class="min-w-0"><small class="font-bold text-slate-400">Email profesional</small><strong class="mt-1 block break-all group-hover:text-cyan">{{ $profile->email }}</strong></span></a>
            <div class="panel flex min-w-0 items-center gap-4 p-5 sm:gap-5 sm:p-6 md:col-span-2 lg:col-span-1"><span class="icon-box text-2xl">⌖</span><span class="min-w-0"><small class="font-bold text-slate-400">Lokasi</small><strong class="mt-1 block break-words">{{ $profile->location }}</strong></span></div>
        </div>

        <div class="mt-12 grid overflow-hidden rounded-3xl bg-white shadow-[0_24px_80px_rgba(17,29,45,.1)] dark:bg-white/[.04] lg:grid-cols-[.9fr_1.1fr]">
            <div class="relative min-h-[440px] min-w-0 overflow-hidden bg-ink p-7 text-white sm:p-12">
                <div class="absolute -right-28 -top-28 size-72 rounded-full border border-white/10"></div><div class="absolute -bottom-20 -left-16 size-64 rounded-full bg-cyan/20 blur-3xl"></div>
                <div class="relative z-10 min-w-0"><p class="kicker text-orange-300">Let’s connect</p><h2 class="break-words text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl">Bicarakan ide Anda bersama saya.</h2><p class="mt-5 text-sm leading-7 text-slate-300 sm:text-base sm:leading-8">Saya terbuka untuk diskusi mengenai analisis sistem, implementasi ERP, integrasi data, automation, dan pengembangan aplikasi bisnis.</p>
                    <div class="mt-10 space-y-5"><div class="flex gap-4"><span class="mt-1 text-cyan">✓</span><p><strong class="block">Diskusi berbasis masalah</strong><span class="text-sm text-slate-400">Mulai dari proses dan kebutuhan, bukan langsung dari fitur.</span></p></div><div class="flex gap-4"><span class="mt-1 text-cyan">✓</span><p><strong class="block">Komunikasi yang terstruktur</strong><span class="text-sm text-slate-400">Requirement, scope, dan ekspektasi dijelaskan sejak awal.</span></p></div><div class="flex gap-4"><span class="mt-1 text-cyan">✓</span><p><strong class="block">Respons profesional</strong><span class="text-sm text-slate-400">Email atau WhatsApp akan saya balas sesegera mungkin.</span></p></div></div>
                </div>
            </div>
            <div class="p-8 sm:p-12" x-data="{ name: '', email: '', subject: '', message: '', send() { window.location.href = `mailto:{{ $profile->email }}?subject=${encodeURIComponent(this.subject || 'Diskusi Portfolio')}&body=${encodeURIComponent('Nama: ' + this.name + '\nEmail: ' + this.email + '\n\n' + this.message)}` } }">
                <p class="kicker">Kirim pesan</p><h2 class="section-title text-3xl sm:text-4xl">Mulai percakapan</h2><p class="mt-4 text-sm leading-7 text-slate-500">Isi informasi berikut. Tombol kirim akan membuka aplikasi email Anda dengan pesan yang sudah disiapkan.</p>
                <form class="mt-8 grid gap-5" @submit.prevent="send()"><div class="grid gap-5 sm:grid-cols-2"><div><label class="label" for="contact-name">Nama</label><input x-model="name" class="field" id="contact-name" required placeholder="Nama lengkap"></div><div><label class="label" for="contact-email">Email</label><input x-model="email" class="field" id="contact-email" type="email" required placeholder="nama@email.com"></div></div><div><label class="label" for="contact-subject">Subjek</label><input x-model="subject" class="field" id="contact-subject" required placeholder="Topik yang ingin didiskusikan"></div><div><label class="label" for="contact-message">Pesan</label><textarea x-model="message" class="field" id="contact-message" rows="6" required placeholder="Ceritakan kebutuhan atau peluang kolaborasi Anda..."></textarea></div><button class="btn-primary w-fit" type="submit">Kirim Pesan <span>↗</span></button></form>
            </div>
        </div>
    </div>
</section>
@endsection
