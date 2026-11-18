@php
    $presentation = match ($selectedRole) {
        'customer' => [
            'accent' => 'text-[#00a99d]',
            'button' => 'bg-[#00a99d] hover:bg-[#008f84]',
            'icon' => 'bag',
            'panel' => 'bg-gradient-to-br from-[#00a98f] to-[#32b4a9]',
            'roleTitle' => 'Daftar sebagai Customer',
        ],
        'umkm' => [
            'accent' => 'text-[#ff6946]',
            'button' => 'bg-[#ff6946] hover:bg-[#f45731]',
            'icon' => 'store',
            'panel' => 'bg-gradient-to-br from-[#ff6b3d] to-[#ff936f]',
            'roleTitle' => 'Daftar sebagai UMKM',
        ],
        default => [
            'accent' => 'text-[#205a98]',
            'button' => 'bg-[#205a98] hover:bg-[#174779]',
            'icon' => 'trend',
            'panel' => 'bg-gradient-to-br from-[#1d4e88] to-[#4d7fb1]',
            'roleTitle' => 'Daftar sebagai Investor',
        ],
    };
@endphp

<main class="min-h-screen bg-white lg:grid lg:grid-cols-2">
    <section class="relative hidden min-h-screen overflow-hidden px-8 py-10 text-white lg:flex lg:flex-col lg:justify-between xl:px-12 {{ $presentation['panel'] }}">
        <div class="pointer-events-none absolute -right-16 -top-20 h-96 w-96 rounded-full bg-white/10"></div>
        <div class="pointer-events-none absolute -bottom-36 -left-24 h-80 w-80 rounded-full bg-white/10"></div>

        <a href="{{ route('landing') }}" class="relative z-10 flex items-center gap-3 text-2xl font-extrabold text-white">
            <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/90"><x-logo size="42" /></span>
            UMatch
        </a>

        <div class="relative z-10 w-full max-w-2xl py-10">
            <span class="mb-8 flex h-24 w-24 items-center justify-center rounded-3xl bg-white/20">
                <x-icon :name="$presentation['icon']" size="48" class="text-white" />
            </span>
            <h1 class="text-4xl font-extrabold leading-tight xl:text-5xl">{{ $presentation['roleTitle'] }}</h1>
            <p class="mt-5 text-lg leading-8 text-white/80">{{ $isAddingRole ? 'Lengkapi profil untuk menambahkan peran ini ke akun UMatch-mu.' : 'Buat akun UMatch sekali, gunakan untuk semua peran.' }}</p>

            <div class="mt-10 rounded-3xl bg-white/15 p-6 backdrop-blur-sm">
                <p class="font-bold">Satu akun, tiga peran:</p>
                <ul class="mt-4 space-y-3 text-white/90">
                    <li class="flex items-center gap-3"><x-icon name="bag" /> Customer — Belanja produk UMKM</li>
                    <li class="flex items-center gap-3"><x-icon name="store" /> UMKM — Kelola usaha &amp; penjualan</li>
                    <li class="flex items-center gap-3"><x-icon name="trend" /> Investor — Temukan UMKM potensial</li>
                </ul>
            </div>
        </div>

        <p class="relative z-10 text-sm text-white/60">Satu akun <span aria-hidden="true">•</span> Tiga peran <span aria-hidden="true">•</span> UMatch</p>
    </section>

    <section class="flex min-h-screen items-center justify-center px-5 py-8 sm:px-10 lg:px-12">
        <div class="w-full max-w-xl">
            <div class="flex justify-end">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 font-semibold {{ $presentation['accent'] }}">
                    <x-icon name="arrow-left" /> Kembali ke login
                </a>
            </div>

            <header class="mb-8 mt-10">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">{{ $isAddingRole ? 'Lengkapi profil role' : 'Buat akun baru' }}</h2>
                <p class="mt-3 text-lg text-slate-500">{{ $isAddingRole ? 'Tambahkan ' : 'Daftar sebagai ' }}<span class="font-bold {{ $presentation['accent'] }}">{{ $roleLabel }}</span>{{ $isAddingRole ? ' ke akun yang sedang aktif.' : ' — gunakan untuk semua peran.' }}</p>
            </header>

            <div class="rounded-[2rem] border border-slate-100 bg-white p-6 shadow-lg shadow-slate-900/5 sm:p-8">
                <div class="mb-7 rounded-2xl border border-teal-100 bg-teal-50 px-5 py-4 leading-7 text-teal-800">
                    @if ($isAddingRole)
                        Profil role ini akan ditautkan ke akun <strong>{{ auth()->user()->email }}</strong> tanpa membuat akun baru.
                    @else
                        Satu akun untuk semua peran. Setelah daftar, kamu otomatis masuk sebagai <strong>{{ $roleLabel }}</strong>.
                    @endif
                </div>

                <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    @unless ($isAddingRole)
                        <div>
                            <label for="name" class="mb-2 block text-sm font-bold text-slate-700">Nama Lengkap</label>
                            <div class="relative">
                                <x-icon name="user" class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" />
                                <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required placeholder="Nama lengkap" class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 pl-12 pr-4 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="mb-2 block text-sm font-bold text-slate-700">Email</label>
                            <div class="relative">
                                <x-icon name="mail" class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" />
                                <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required placeholder="nama@email.com" class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 pl-12 pr-4 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                            </div>
                        </div>

                        <div>
                            <label for="no_hp" class="mb-2 block text-sm font-bold text-slate-700">Nomor HP</label>
                            <div class="relative">
                                <x-icon name="phone" class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" />
                                <input id="no_hp" name="no_hp" type="tel" value="{{ old('no_hp') }}" autocomplete="tel" inputmode="tel" required placeholder="+62 812-3456-7890" class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 pl-12 pr-4 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-bold text-slate-700">Password</label>
                            <div class="relative">
                                <x-icon name="lock" class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" />
                                <input id="password" name="password" type="password" autocomplete="new-password" required minlength="6" placeholder="Min. 6 karakter" class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 pl-12 pr-12 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                                <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"><x-icon name="eye" /></span>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-2 block text-sm font-bold text-slate-700">Konfirmasi Password</label>
                            <div class="relative">
                                <x-icon name="lock" class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" />
                                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required placeholder="Ulangi password" class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 pl-12 pr-4 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                            </div>
                        </div>
                    @endunless

                    @if ($isAddingRole && $needsPhone)
                        <div>
                            <label for="no_hp" class="mb-2 block text-sm font-bold text-slate-700">Nomor HP</label>
                            <div class="relative">
                                <x-icon name="phone" class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" />
                                <input id="no_hp" name="no_hp" type="tel" value="{{ old('no_hp') }}" autocomplete="tel" inputmode="tel" required placeholder="+62 812-3456-7890" class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 pl-12 pr-4 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                            </div>
                        </div>
                    @endif

                    @if ($selectedRole === 'customer')
                        <div class="border-t border-slate-100 pt-5">
                            <h3 class="text-lg font-extrabold text-slate-900">Profil Customer</h3>
                            <p class="mt-1 text-sm text-slate-500">Informasi alamat bersifat opsional dan dapat dilengkapi nanti.</p>
                        </div>
                        <div>
                            <label for="alamat" class="mb-2 block text-sm font-bold text-slate-700">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="3" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">{{ old('alamat') }}</textarea>
                        </div>
                        <div>
                            <label for="kota" class="mb-2 block text-sm font-bold text-slate-700">Kota</label>
                            <input id="kota" name="kota" value="{{ old('kota') }}" class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                        </div>
                    @elseif ($selectedRole === 'umkm')
                        <div class="border-t border-slate-100 pt-5">
                            <h3 class="text-lg font-extrabold text-slate-900">Profil Usaha</h3>
                            <p class="mt-1 text-sm text-slate-500">Data usaha dan dokumen akan dikirim untuk verifikasi Admin.</p>
                        </div>
                        <div>
                            <label for="nama_usaha" class="mb-2 block text-sm font-bold text-slate-700">Nama Usaha</label>
                            <input id="nama_usaha" name="nama_usaha" value="{{ old('nama_usaha') }}" required class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                        </div>
                        <div>
                            <label for="kategori_usaha" class="mb-2 block text-sm font-bold text-slate-700">Kategori Usaha</label>
                            <input id="kategori_usaha" name="kategori_usaha" value="{{ old('kategori_usaha') }}" required placeholder="Contoh: Makanan & Minuman" class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                        </div>
                        <div>
                            <label for="deskripsi" class="mb-2 block text-sm font-bold text-slate-700">Deskripsi Usaha</label>
                            <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">{{ old('deskripsi') }}</textarea>
                        </div>
                        <div>
                            <label for="alamat_usaha" class="mb-2 block text-sm font-bold text-slate-700">Alamat Usaha</label>
                            <textarea id="alamat_usaha" name="alamat_usaha" rows="2" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">{{ old('alamat_usaha') }}</textarea>
                        </div>
                        <div>
                            <label for="kontak_usaha" class="mb-2 block text-sm font-bold text-slate-700">Kontak Usaha</label>
                            <input id="kontak_usaha" name="kontak_usaha" value="{{ old('kontak_usaha') }}" class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                        </div>
                        <label class="flex items-center gap-3 rounded-2xl border border-slate-200 p-4 text-sm font-semibold text-slate-700">
                            <input type="checkbox" name="terima_investasi" value="1" @checked(old('terima_investasi')) class="rounded border-slate-300 text-orange-600 focus:ring-orange-500">
                            Saya terbuka menerima penawaran investasi
                        </label>
                        <div>
                            <label for="jenis_dokumen" class="mb-2 block text-sm font-bold text-slate-700">Jenis Dokumen Usaha</label>
                            <select id="jenis_dokumen" name="jenis_dokumen" required class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                                <option value="">Pilih jenis dokumen</option>
                                @foreach (['NIB', 'Surat Izin Usaha', 'Lainnya'] as $documentType)
                                    <option value="{{ $documentType }}" @selected(old('jenis_dokumen') === $documentType)>{{ $documentType }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="dokumen_usaha" class="mb-2 block text-sm font-bold text-slate-700">Unggah Dokumen Usaha</label>
                            <input id="dokumen_usaha" name="dokumen_usaha" type="file" accept=".pdf,.jpg,.jpeg,.png" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm text-slate-600 file:mr-4 file:rounded-xl file:border-0 file:bg-orange-50 file:px-4 file:py-2 file:font-bold file:text-orange-700">
                            <p class="mt-2 text-xs text-slate-500">PDF/JPG/PNG, maksimal 5 MB. File disimpan secara privat.</p>
                        </div>
                    @else
                        <div class="border-t border-slate-100 pt-5">
                            <h3 class="text-lg font-extrabold text-slate-900">Profil dan Verifikasi Investor</h3>
                            <p class="mt-1 text-sm text-slate-500">Pengajuan akan berstatus Pending sampai diperiksa secara manual oleh Admin.</p>
                        </div>
                        <div>
                            <label for="nik" class="mb-2 block text-sm font-bold text-slate-700">NIK</label>
                            <input id="nik" name="nik" value="{{ old('nik') }}" inputmode="numeric" pattern="[0-9]{16}" minlength="16" maxlength="16" required class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                        </div>
                        <div>
                            <label for="pekerjaan" class="mb-2 block text-sm font-bold text-slate-700">Pekerjaan</label>
                            <input id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" required class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                        </div>
                        <div>
                            <label for="penghasilan" class="mb-2 block text-sm font-bold text-slate-700">Penghasilan per Bulan (Rp)</label>
                            <input id="penghasilan" name="penghasilan" type="number" min="0" step="0.01" value="{{ old('penghasilan') }}" required class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                        </div>
                        <div>
                            <label for="jenis_investor" class="mb-2 block text-sm font-bold text-slate-700">Jenis Investor</label>
                            <select id="jenis_investor" name="jenis_investor" required class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                                <option value="">Pilih jenis investor</option>
                                @foreach (['Individu', 'Institusi'] as $investorType)
                                    <option value="{{ $investorType }}" @selected(old('jenis_investor') === $investorType)>{{ $investorType }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="tingkat_risiko" class="mb-2 block text-sm font-bold text-slate-700">Profil Risiko</label>
                            <select id="tingkat_risiko" name="tingkat_risiko" required class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">
                                <option value="">Pilih profil risiko</option>
                                @foreach (['Konservatif', 'Moderat', 'Agresif'] as $riskLevel)
                                    <option value="{{ $riskLevel }}" @selected(old('tingkat_risiko') === $riskLevel)>{{ $riskLevel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="tujuan_investasi" class="mb-2 block text-sm font-bold text-slate-700">Tujuan Investasi</label>
                            <textarea id="tujuan_investasi" name="tujuan_investasi" rows="3" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-4 focus:ring-slate-100">{{ old('tujuan_investasi') }}</textarea>
                        </div>
                        <div>
                            <label for="ktp" class="mb-2 block text-sm font-bold text-slate-700">Unggah KTP</label>
                            <input id="ktp" name="ktp" type="file" accept=".pdf,.jpg,.jpeg,.png" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm text-slate-600 file:mr-4 file:rounded-xl file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:font-bold file:text-blue-700">
                            <p class="mt-2 text-xs text-slate-500">PDF/JPG/PNG, maksimal 5 MB. Disimpan privat untuk pemeriksaan manual.</p>
                        </div>
                        <div>
                            <label for="selfie" class="mb-2 block text-sm font-bold text-slate-700">Unggah Selfie untuk Verifikasi Manual</label>
                            <input id="selfie" name="selfie" type="file" accept=".jpg,.jpeg,.png,.webp" required class="block w-full rounded-2xl border border-slate-200 bg-slate-50 p-3 text-sm text-slate-600 file:mr-4 file:rounded-xl file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:font-bold file:text-blue-700">
                            <p class="mt-2 text-xs text-slate-500">JPG/PNG/WEBP, maksimal 5 MB. Pemeriksaan dilakukan Admin, bukan face recognition otomatis.</p>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div role="alert" class="rounded-2xl bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
                    @endif

                    <button type="submit" class="h-16 w-full rounded-2xl px-5 font-bold text-white shadow-lg transition focus:outline-none focus:ring-4 focus:ring-slate-200 {{ $presentation['button'] }}">
                        {{ $isAddingRole ? 'Tambahkan Role ' : 'Daftar & Masuk sebagai ' }}{{ $roleLabel }}
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>
