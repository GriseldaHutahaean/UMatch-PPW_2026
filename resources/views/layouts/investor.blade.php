@php($user = auth()->user())
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Investor — UMatch')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="min-h-screen bg-[#FAFAFB] font-[Plus_Jakarta_Sans,ui-sans-serif,sans-serif] text-gray-900">
    <header class="sticky top-0 z-30 h-16 border-b border-gray-100 bg-white">
        <div class="mx-auto flex h-full max-w-[1440px] items-center gap-4 px-4 sm:px-6">
            <button type="button" class="rounded-lg p-2 text-gray-500 hover:bg-gray-50 lg:hidden" data-sidebar-toggle aria-label="Buka navigasi"><x-icon name="menu" size="20" /></button>
            <a href="{{ route('investor.dashboard') }}" class="flex shrink-0 items-center gap-2"><x-logo size="28" /><span class="text-base font-extrabold tracking-tight text-gray-900">UMatch</span><span class="rounded-full bg-[#1E4E8C] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">Investor</span></a>
            <form method="GET" action="{{ route('investor.explore') }}" role="search" class="relative ml-2 hidden w-80 md:block lg:w-96"><x-icon name="search" size="17" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" /><input type="search" name="q" value="{{ request()->query('q') }}" placeholder="Cari UMKM atau lokasi..." aria-label="Cari UMKM" class="w-full rounded-full border border-gray-200 bg-[#F8FAFC] py-2 pl-11 pr-4 text-xs text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#93C5FD] focus:ring-2 focus:ring-blue-100"></form>
            <div class="ml-auto flex items-center gap-2 sm:gap-3">
                <button type="button" class="relative flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 text-gray-500 transition hover:bg-gray-50" data-toast="Tidak ada notifikasi baru" aria-label="Notifikasi"><x-icon name="bell" size="18" /><span class="absolute right-2 top-2 h-1.5 w-1.5 rounded-full bg-[#1E4E8C]"></span></button>
                <div class="relative">
                    <button type="button" class="flex items-center gap-2 rounded-full border border-[#93C5FD] bg-[#EAF1FA] px-3 py-1.5 text-xs font-bold text-[#1E4E8C] transition hover:bg-blue-100" data-role-menu-toggle aria-expanded="false">Investor<x-icon name="chevron-down" size="14" /></button>
                    <div class="absolute right-0 top-12 hidden w-52 rounded-xl border border-gray-100 bg-white p-1.5 shadow-xl" data-role-menu>
                        <p class="px-3 pb-1.5 pt-2 text-[10px] font-bold uppercase tracking-wider text-gray-400">Ganti Role</p>
                        @foreach (config('umatch.roles') as $roleKey => $availableRole)
                            <form action="{{ route('roles.select') }}" method="POST">@csrf<input type="hidden" name="role" value="{{ $roleKey }}"><button type="submit" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-xs font-medium text-gray-700 hover:bg-blue-50 hover:text-[#1E4E8C]"><span>{{ $availableRole['label'] }}</span>@if ($roleKey === 'investor')<span class="text-[10px] font-bold text-[#1E4E8C]">Aktif</span>@endif</button></form>
                        @endforeach
                    </div>
                </div>
                <div class="relative">
                    <button type="button" class="flex h-9 w-9 items-center justify-center rounded-full bg-[#1E4E8C] text-sm font-semibold text-white transition hover:ring-4 hover:ring-blue-100" data-profile-menu-toggle aria-expanded="false" aria-label="Buka profil">{{ mb_strtoupper(mb_substr($user->nama, 0, 1)) }}</button>
                    <div class="absolute right-0 top-12 hidden w-60 rounded-xl border border-gray-100 bg-white p-2 shadow-xl" data-profile-menu>
                        <div class="rounded-lg bg-blue-50 px-3 py-3"><p class="text-sm font-bold text-gray-900">{{ $user->nama }}</p><p class="mt-0.5 truncate text-xs text-gray-500">{{ $user->email }}</p><p class="mt-2 text-[10px] font-bold uppercase tracking-wider text-[#1E4E8C]">Profil Investor</p></div>
                        <button type="button" data-toast="Profil kamu sedang aktif" class="mt-1.5 block w-full rounded-lg px-3 py-2 text-left text-xs font-medium text-gray-700 hover:bg-gray-50">Profil Saya</button>
                        <form action="{{ route('logout') }}" method="POST" class="mt-1.5 border-t border-gray-100 pt-1.5">@csrf<button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-xs font-medium text-red-600 hover:bg-red-50">Keluar</button></form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="mx-auto flex max-w-[1440px]">
        <aside class="fixed bottom-0 left-0 top-16 z-20 hidden w-60 border-r border-gray-100 bg-white lg:block"><x-investor-navigation /></aside>
        <div class="fixed inset-0 z-10 hidden bg-gray-900/20 lg:hidden" data-sidebar-backdrop></div>
        <aside class="fixed bottom-0 left-0 top-16 z-20 hidden w-60 border-r border-gray-100 bg-white lg:hidden" data-mobile-sidebar><x-investor-navigation /></aside>

        <main class="w-full px-4 py-6 sm:px-6 md:p-8 lg:ml-60">
            @yield('content')
        </main>
    </div>
</div>

<div class="fixed bottom-5 right-5 z-[60] hidden max-w-xs rounded-xl bg-gray-900 px-4 py-3 text-sm font-medium text-white shadow-xl" data-toast-message></div>

@stack('scripts')
<script>
const toastMessage = document.querySelector('[data-toast-message]');
let toastTimer;
function showToast(message) { toastMessage.textContent = message; toastMessage.classList.remove('hidden'); clearTimeout(toastTimer); toastTimer = setTimeout(() => toastMessage.classList.add('hidden'), 2600); }
document.querySelectorAll('[data-toast]').forEach((element) => element.addEventListener('click', () => showToast(element.dataset.toast)));

const roleMenuToggle = document.querySelector('[data-role-menu-toggle]');
const roleMenu = document.querySelector('[data-role-menu]');
const profileMenuToggle = document.querySelector('[data-profile-menu-toggle]');
const profileMenu = document.querySelector('[data-profile-menu]');
roleMenuToggle.addEventListener('click', () => {
    const isOpen = !roleMenu.classList.contains('hidden');
    roleMenu.classList.toggle('hidden', isOpen);
    roleMenuToggle.setAttribute('aria-expanded', String(!isOpen));
    profileMenu.classList.add('hidden');
    profileMenuToggle.setAttribute('aria-expanded', 'false');
});
profileMenuToggle.addEventListener('click', () => {
    const isOpen = !profileMenu.classList.contains('hidden');
    profileMenu.classList.toggle('hidden', isOpen);
    profileMenuToggle.setAttribute('aria-expanded', String(!isOpen));
    roleMenu.classList.add('hidden');
    roleMenuToggle.setAttribute('aria-expanded', 'false');
});
document.addEventListener('click', (event) => {
    if (!roleMenu.contains(event.target) && !roleMenuToggle.contains(event.target)) {
        roleMenu.classList.add('hidden');
        roleMenuToggle.setAttribute('aria-expanded', 'false');
    }
    if (!profileMenu.contains(event.target) && !profileMenuToggle.contains(event.target)) {
        profileMenu.classList.add('hidden');
        profileMenuToggle.setAttribute('aria-expanded', 'false');
    }
});

const mobileSidebar = document.querySelector('[data-mobile-sidebar]');
const sidebarBackdrop = document.querySelector('[data-sidebar-backdrop]');
function toggleMobileSidebar(open) { mobileSidebar.classList.toggle('hidden', !open); sidebarBackdrop.classList.toggle('hidden', !open); }
document.querySelector('[data-sidebar-toggle]').addEventListener('click', () => toggleMobileSidebar(true));
sidebarBackdrop.addEventListener('click', () => toggleMobileSidebar(false));
</script>
</body>
</html>
