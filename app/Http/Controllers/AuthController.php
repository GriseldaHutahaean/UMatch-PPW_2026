<?php

namespace App\Http\Controllers;

use App\Models\CustomerProfile;
use App\Models\InvestorDocument;
use App\Models\InvestorProfile;
use App\Models\Role;
use App\Models\UmkmDocument;
use App\Models\UmkmProfile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class AuthController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $selectedRole = session('selected_role', $request->string('role')->toString());

        $loginRoles = array_merge(
            config('umatch.roles', []),
            config('umatch.internal_roles', []),
        );

        if (! array_key_exists($selectedRole, $loginRoles)) {
            return redirect()->route('roles.choose');
        }

        session()->put('selected_role', $selectedRole);

        return view('auth.login', [
            'selectedRole' => $selectedRole,
            'roleLabel' => $loginRoles[$selectedRole]['label'],
        ]);
    }

    public function selectRole(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'string', Rule::in(array_keys(config('umatch.roles', [])))],
        ]);

        $request->session()->put('selected_role', $validated['role']);

        return Auth::check()
            ? redirect()->route('register')
            : redirect()->route('login');
    }

    public function showRegister(): View|RedirectResponse
    {
        $selectedRole = session('selected_role');

        if (! array_key_exists($selectedRole, config('umatch.roles', []))) {
            return redirect()->route('roles.choose');
        }

        $isAddingRole = Auth::check();
        $needsPhone = $isAddingRole && blank(Auth::user()->no_hp);

        if ($isAddingRole && $this->roleProfileExists(Auth::user(), $selectedRole)) {
            return redirect()->route('dashboard');
        }

        $registerView = $selectedRole === 'investor'
            ? 'auth.register-investor'
            : 'auth.register';

        return view($registerView, [
            'selectedRole' => $selectedRole,
            'roleLabel' => config("umatch.roles.{$selectedRole}.label"),
            'isAddingRole' => $isAddingRole,
            'needsPhone' => $needsPhone,
        ]);
    }

    public function register(Request $request): RedirectResponse
    {
        $selectedRole = session('selected_role');

        if (! array_key_exists($selectedRole, config('umatch.roles', []))) {
            return redirect()->route('roles.choose');
        }

        $existingUser = Auth::user();

        if ($existingUser !== null && $this->roleProfileExists($existingUser, $selectedRole)) {
            return redirect()->route('dashboard');
        }

        $rules = $existingUser === null ? [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'no_hp' => [
                'required',
                'string',
                'max:20',
                'regex:/^\\+?(?=(?:[^0-9]*[0-9]){8,15}[^0-9]*$)[0-9][0-9\\s().-]*[0-9]$/',
            ],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ] : [];

        if ($existingUser !== null && blank($existingUser->no_hp)) {
            $rules['no_hp'] = [
                'required',
                'string',
                'max:20',
                'regex:/^\\+?(?=(?:[^0-9]*[0-9]){8,15}[^0-9]*$)[0-9][0-9\\s().-]*[0-9]$/',
            ];
        }

        $rules = array_merge($rules, match ($selectedRole) {
            'customer' => [
                'alamat' => ['nullable', 'string', 'max:2000'],
                'kota' => ['nullable', 'string', 'max:255'],
            ],
            'umkm' => [
                'nama_usaha' => ['required', 'string', 'max:255'],
                'kategori_usaha' => ['required', 'string', 'max:255'],
                'deskripsi' => ['nullable', 'string', 'max:5000'],
                'alamat_usaha' => ['nullable', 'string', 'max:2000'],
                'kontak_usaha' => ['nullable', 'string', 'max:50'],
                'terima_investasi' => ['sometimes', 'boolean'],
                'jenis_dokumen' => ['required', 'string', Rule::in(['NIB', 'Surat Izin Usaha', 'Lainnya'])],
                'dokumen_usaha' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            ],
            'investor' => [
                'nik' => ['required', 'digits:16'],
                'pekerjaan' => ['required', 'string', 'max:255'],
                'penghasilan' => ['required', 'numeric', 'min:0', 'max:9999999999999.99'],
                'jenis_investor' => ['required', 'string', Rule::in(['Individu', 'Institusi'])],
                'tingkat_risiko' => ['required', 'string', Rule::in(['Konservatif', 'Moderat', 'Agresif'])],
                'tujuan_investasi' => ['required', 'string', 'max:5000'],
                'ktp' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
                'selfie' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            ],
        });

        $validated = $request->validate($rules);
        $storedPaths = [];

        try {
            $user = DB::transaction(function () use ($validated, $selectedRole, $existingUser, &$storedPaths): User {
                $user = $existingUser ?? User::query()->create([
                    'nama' => $validated['name'],
                    'email' => $validated['email'],
                    'no_hp' => $validated['no_hp'],
                    'password' => $validated['password'],
                    'status_akun' => 'aktif',
                ]);

                if ($existingUser !== null && isset($validated['no_hp'])) {
                    $user->forceFill(['no_hp' => $validated['no_hp']])->save();
                }

                $role = Role::query()->firstOrCreate(['nama_role' => $selectedRole]);

                if (! $user->roles()->whereKey($role->getKey())->exists()) {
                    $user->roles()->attach($role->getKey(), ['tanggal_aktif' => now()]);
                }

                if ($selectedRole === 'customer') {
                    CustomerProfile::query()->create([
                        'user_id' => $user->getKey(),
                        'alamat' => $validated['alamat'] ?? null,
                        'kota' => $validated['kota'] ?? null,
                    ]);
                }

                if ($selectedRole === 'umkm') {
                    $umkmProfile = UmkmProfile::query()->create([
                        'user_id' => $user->getKey(),
                        'nama_usaha' => $validated['nama_usaha'],
                        'kategori_usaha' => $validated['kategori_usaha'],
                        'deskripsi' => $validated['deskripsi'] ?? null,
                        'alamat_usaha' => $validated['alamat_usaha'] ?? null,
                        'kontak_usaha' => $validated['kontak_usaha'] ?? null,
                        'status_verifikasi' => 'pending',
                        'terima_investasi' => $validated['terima_investasi'] ?? false,
                    ]);

                    $documentPath = $validated['dokumen_usaha']->store("documents/umkm/{$user->getKey()}", 'local');

                    if (! is_string($documentPath)) {
                        throw new RuntimeException('Dokumen usaha gagal disimpan.');
                    }

                    $storedPaths[] = $documentPath;

                    UmkmDocument::query()->create([
                        'umkm_profile_id' => $umkmProfile->getKey(),
                        'jenis_dokumen' => $validated['jenis_dokumen'],
                        'file_dokumen' => $documentPath,
                        'tanggal_unggah' => now(),
                    ]);
                }

                if ($selectedRole === 'investor') {
                    $investorProfile = InvestorProfile::query()->create([
                        'user_id' => $user->getKey(),
                        'nik' => $validated['nik'],
                        'pekerjaan' => $validated['pekerjaan'],
                        'penghasilan' => $validated['penghasilan'],
                        'jenis_investor' => $validated['jenis_investor'],
                        'tingkat_risiko' => $validated['tingkat_risiko'],
                        'tujuan_investasi' => $validated['tujuan_investasi'],
                        'status_verifikasi' => 'pending',
                    ]);

                    foreach (['KTP' => 'ktp', 'Selfie' => 'selfie'] as $documentType => $inputName) {
                        $documentPath = $validated[$inputName]->store("documents/investor/{$user->getKey()}", 'local');

                        if (! is_string($documentPath)) {
                            throw new RuntimeException('Dokumen KYC gagal disimpan.');
                        }

                        $storedPaths[] = $documentPath;

                        InvestorDocument::query()->create([
                            'investor_profile_id' => $investorProfile->getKey(),
                            'jenis_dokumen' => $documentType,
                            'file_dokumen' => $documentPath,
                            'tanggal_unggah' => now(),
                        ]);
                    }
                }

                return $user;
            });
        } catch (Throwable $exception) {
            Storage::disk('local')->delete($storedPaths);

            throw $exception;
        }

        if (! Auth::check()) {
            Auth::login($user);
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    private function roleProfileExists(User $user, string $role): bool
    {
        if (! $user->hasRole($role)) {
            return false;
        }

        return match ($role) {
            'customer' => $user->customerProfile()->exists(),
            'umkm' => $user->umkmProfile()->exists(),
            'investor' => $user->investorProfile()->exists(),
            default => false,
        };
    }

    public function login(Request $request): JsonResponse|RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Email atau password salah.'], 422)
                : back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }

        $request->session()->regenerate();

        return $request->expectsJson()
            ? response()->json(['redirect' => route('dashboard')])
            : redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        $selectedRole = $request->session()->get('selected_role');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $selectedRole
            ? redirect()->route('login', ['role' => $selectedRole])
            : redirect()->route('roles.choose');
    }
}
