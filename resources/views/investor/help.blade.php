@extends('layouts.investor')

@section('title', 'Pusat Bantuan — UMatch')

@section('content')
<div class="mx-auto max-w-7xl space-y-7">
    <section>
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Pusat Bantuan</h1>
        <p class="mt-0.5 text-sm text-gray-400">Pertanyaan yang sering diajukan (FAQ) dan kontak resmi UMatch</p>
    </section>

    @forelse ($faqGroups as $category => $faqs)
        <section class="rounded-2xl border border-[#F1F5F9] bg-white p-5 shadow-[0_2px_10px_rgba(0,0,0,0.03)] sm:p-6">
            <h2 class="text-base font-bold text-gray-900">{{ $category }}</h2>
            <div class="mt-3 divide-y divide-gray-100">
                @foreach ($faqs as $faq)
                    <details class="group py-3">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-3 text-sm font-semibold text-gray-900 [&::-webkit-details-marker]:hidden">
                            <span>{{ $faq->pertanyaan }}</span>
                            <x-icon name="chevron-down" size="16" class="shrink-0 text-gray-400 transition group-open:rotate-180" />
                        </summary>
                        <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-gray-600">{{ $faq->jawaban }}</p>
                    </details>
                @endforeach
            </div>
        </section>
    @empty
        <section class="rounded-2xl border border-[#F1F5F9] bg-white p-10 text-center shadow-[0_2px_10px_rgba(0,0,0,0.03)]">
            <p class="text-sm font-semibold text-gray-900">Belum ada FAQ</p>
            <p class="mt-1 text-xs text-gray-400">Pertanyaan yang sering diajukan akan tampil di sini.</p>
        </section>
    @endforelse

    <section class="flex flex-col gap-4 rounded-2xl border border-[#BFD3EC] bg-[#EAF1FA] p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <h2 class="text-base font-bold text-gray-900">Kontak Resmi UMatch</h2>
            <p class="mt-1 text-sm text-gray-600">Hubungi kami jika jawaban tidak ditemukan atau kamu tidak bisa mengakses email akunmu.</p>
        </div>
        <a href="mailto:{{ $supportEmail }}" class="inline-flex w-fit shrink-0 items-center gap-2 rounded-xl bg-[#1E4E8C] px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-[#173F73]"><x-icon name="mail" size="17" />{{ $supportEmail }}</a>
    </section>
</div>
@endsection
