@props(['value', 'label', 'color' => 'orange'])
@php($colorClass = ['orange' => 'text-orange-500', 'emerald' => 'text-emerald-500', 'amber' => 'text-amber-500', 'red' => 'text-red-500', 'blue' => 'text-blue-500'][$color] ?? 'text-orange-500')
<article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm"><p class="text-2xl font-extrabold {{ $colorClass }}">{{ $value }}</p><p class="mt-1 text-xs text-slate-400">{{ $label }}</p></article>
