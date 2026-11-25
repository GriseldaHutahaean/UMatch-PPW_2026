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
        @case('layout-grid')<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>@break
        @case('package')<path d="M21 8.5L12 3 3 8.5v7L12 21l9-5.5z"/><path d="M3 8.5l9 5 9-5M12 13.5V21"/>@break
        @case('clipboard')<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M8 9h8M8 13h6M8 17h4"/>@break
        @case('bar-chart')<path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>@break
        @case('trending-up')<path d="M3 17l6-6 4 4 8-8"/><path d="M15 7h6v6"/>@break
        @case('users')<circle cx="9" cy="8" r="3"/><path d="M3 20a6 6 0 0 1 12 0M16 5.5a3 3 0 0 1 0 5.8M18 14a5 5 0 0 1 3 4"/>@break
        @case('file-text')<path d="M6 3h8l4 4v14H6z"/><path d="M14 3v5h5M9 12h6M9 16h6"/>@break
        @case('bell')<path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/>@break
        @case('search')<circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>@break
        @case('chevron-down')<path d="m6 9 6 6 6-6"/>@break
        @case('plus')<path d="M12 5v14M5 12h14"/>@break
        @case('alert-triangle')<path d="m12 3 9 17H3z"/><path d="M12 9v4M12 17h.01"/>@break
        @case('shopping-bag')<path d="M5 8h14l-1 12H6z"/><path d="M9 8a3 3 0 0 1 6 0"/>@break
        @case('box')<path d="m4 7 8-4 8 4-8 4zM4 7v10l8 4 8-4V7M12 11v10"/>@break
        @case('menu')<path d="M4 6h16M4 12h16M4 18h16"/>@break
        @case('x')<path d="m6 6 12 12M18 6 6 18"/>@break
        @case('briefcase')<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2M3 13h18"/>@break
        @case('help-circle')<circle cx="12" cy="12" r="9"/><path d="M9.5 9a2.5 2.5 0 1 1 3.5 2.3c-.7.3-1 .9-1 1.7M12 17h.01"/>@break
    @endswitch
</svg>
