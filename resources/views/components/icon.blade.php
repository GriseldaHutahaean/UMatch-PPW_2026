{{-- Ikon garis sederhana (gaya Tabler Icons). Contoh: <x-icon name="mail" /> --}}
@props(['name', 'size' => 20])
<svg {{ $attributes->merge(['class' => 'icon']) }} width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none"
     stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($name)
        @case('bag')<path d="M6 8h12l-1 12H7z"/><path d="M9 8a3 3 0 0 1 6 0"/>@break
        @case('store')<path d="M3 9l1.5-5h15L21 9"/><path d="M3 9h18v1.5a3 3 0 0 1-6 0 3 3 0 0 1-6 0 3 3 0 0 1-6 0z"/><path d="M5 13v7h14v-7"/><path d="M10 20v-4h4v4"/>@break
        @case('trend')<path d="M3 17l6-6 4 4 8-8"/><path d="M14 7h7v7"/>@break
        @case('check')<circle cx="12" cy="12" r="9"/><path d="M8.5 12.5l2.4 2.4 4.6-5"/>@break
        @case('mail')<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>@break
        @case('lock')<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/>@break
        @case('user')<circle cx="12" cy="8" r="4"/><path d="M5 21a7 7 0 0 1 14 0"/>@break
        @case('phone')<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/>@break
        @case('eye')<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>@break
        @case('arrow-left')<path d="M19 12H5"/><path d="M11 6l-6 6 6 6"/>@break
        @case('arrow-right')<path d="M5 12h14"/><path d="M13 6l6 6-6 6"/>@break
        @case('shield')<path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="M9 12l2 2 4-4"/>@break
    @endswitch
</svg>
