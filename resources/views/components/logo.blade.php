{{-- Logo UMatch (SVG). Ganti dengan <img src="{{ asset('images/logo.png') }}"> kalau sudah punya file logo resmi. --}}
@props(['size' => 28])
<svg {{ $attributes }} width="{{ $size }}" height="{{ $size }}" viewBox="0 0 48 40" aria-hidden="true">
    <defs>
        <linearGradient id="umatch-mid" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#F9B21B"/><stop offset="1" stop-color="#F2862B"/>
        </linearGradient>
    </defs>
    <circle cx="9.5" cy="10" r="4.6" fill="#1F4E9C"/>
    <circle cx="24" cy="6.5" r="5" fill="#F9B21B"/>
    <circle cx="38.5" cy="10" r="4.6" fill="#1E9B5F"/>
    <path d="M5 17h8.6v9.5c0 3.2 1.6 5.8 4.2 7.4l-2.1 2.6C9.6 34.2 5 29 5 22.8z" fill="#1F4E9C"/>
    <path d="M18 14.5h12v6.3c0 6.2-2.4 11.3-6 15.2-3.6-3.9-6-9-6-15.2z" fill="url(#umatch-mid)"/>
    <path d="M43 17h-8.6v9.5c0 3.2-1.6 5.8-4.2 7.4l2.1 2.6C38.4 34.2 43 29 43 22.8z" fill="#1E9B5F"/>
</svg>
