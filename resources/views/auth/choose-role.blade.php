@extends('layouts.auth')

@section('title', 'Masuk sebagai apa? — UMatch')
@section('body-class', 'choose-page')

@section('content')
    <header class="topbar">
        <a href="{{ route('landing') }}" class="brand"><x-logo size="26" /> <span>UMatch</span></a>
    </header>

    <main class="choose">
        <p class="eyebrow">UMATCH</p>
        <h1>Masuk sebagai apa?</h1>
        <p class="choose-sub">Pilih peran yang ingin kamu gunakan.</p>
        <p class="quote-pill">"Belanja, Berjualan, dan Berinvestasi dalam Satu Akun."</p>

        <div class="role-cards">
            @foreach (config('umatch.roles') as $key => $role)
                <article class="role-card theme-{{ $key }}">
                    <div class="role-thumb">
                        {{-- Kalau ada foto di public/images/role-customer.jpg (dst.), foto itu yang dipakai --}}
                        @if (file_exists(public_path("images/role-{$key}.jpg")))
                            <img src="{{ asset("images/role-{$key}.jpg") }}" alt="">
                        @else
                            <x-icon :name="$role['icon']" size="34" />
                        @endif
                    </div>
                    <h2>{{ $role['label'] }}</h2>
                    <p>{{ $role['subtitle'] }}</p>
                    <a href="{{ route('login', ['role' => $key]) }}" class="btn btn-role">Masuk sebagai {{ $role['label'] }}</a>
                </article>
            @endforeach
        </div>
    </main>
@endsection
