@extends('layouts.auth')

@section('title', 'Daftar sebagai '.$roleLabel.' — UMatch')
@section('body-class', 'min-h-screen bg-white text-slate-900')

@section('content')
    @include('auth.partials.register-page')
@endsection
