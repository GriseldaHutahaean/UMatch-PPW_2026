<?php

namespace App\Http\Controllers;

use App\Models\UmkmProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class InvestorDashboardController extends Controller
{
    /**
     * Dashboard Investor. Status KYC dan profil risiko diambil dari profil investor,
     * sedangkan angka ringkasan masih berupa data contoh seperti dashboard UMKM.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $profile = $user->investorProfile;

        return view('investor.dashboard', [
            'user' => $user,
            'kycStatus' => $profile?->status_verifikasi ?? 'pending',
            'riskProfile' => $profile?->tingkat_risiko,
            'today' => now()->locale('id')->translatedFormat('l, d M Y'),
            'kpis' => [
                ['label' => 'Total Investasi', 'value' => 'Rp 80.000.000', 'change' => '3 UMKM', 'icon' => 'bar-chart', 'iconClass' => 'bg-[#EFF6FF] text-[#2563EB]'],
                ['label' => 'Nilai Portofolio', 'value' => 'Rp 92.400.000', 'change' => '+15,5%', 'icon' => 'trending-up', 'iconClass' => 'bg-[#E6F7F4] text-[#00A88F]'],
                ['label' => 'Return Investasi', 'value' => 'Rp 12.400.000', 'change' => '+15,5%', 'icon' => 'file-text', 'iconClass' => 'bg-[#EEF2FF] text-[#6366F1]'],
                ['label' => 'Tawaran Menunggu', 'value' => '2 tawaran', 'change' => 'Menunggu UMKM', 'icon' => 'users', 'iconClass' => 'bg-[#FFFBEB] text-[#F59E0B]'],
            ],
            'chart' => [
                ['month' => 'Jun', 'short' => '80jt', 'amount' => 'Rp 80.000.000', 'height' => '60%'],
                ['month' => 'Jul', 'short' => '82jt', 'amount' => 'Rp 82.000.000', 'height' => '68%'],
                ['month' => 'Agu', 'short' => '84,5jt', 'amount' => 'Rp 84.500.000', 'height' => '76%'],
                ['month' => 'Sep', 'short' => '87jt', 'amount' => 'Rp 87.000.000', 'height' => '85%'],
                ['month' => 'Okt', 'short' => '90jt', 'amount' => 'Rp 90.000.000', 'height' => '93%'],
                ['month' => 'Nov', 'short' => '92,4jt', 'amount' => 'Rp 92.400.000', 'height' => '100%'],
            ],
            'offers' => [
                ['name' => 'Dapur Batak', 'detail' => 'Rp 50 juta • 15% ekuitas • 20 Nov 2026', 'status' => 'Menunggu', 'statusClass' => 'bg-[#FFFBEB] text-[#D97706]'],
                ['name' => 'Kopi Sidikalang Roasters', 'detail' => 'Rp 30 juta • 10% ekuitas • 18 Nov 2026', 'status' => 'Menunggu', 'statusClass' => 'bg-[#FFFBEB] text-[#D97706]'],
                ['name' => 'Tenun Ulos Sibolga', 'detail' => 'Rp 25 juta • 8% ekuitas • 10 Nov 2026', 'status' => 'Diterima', 'statusClass' => 'bg-[#ECFDF5] text-[#10B981]'],
                ['name' => 'Keripik Singkong Balige', 'detail' => 'Rp 15 juta • 5% ekuitas • 02 Nov 2026', 'status' => 'Ditolak', 'statusClass' => 'bg-[#FEF2F2] text-[#EF4444]'],
            ],
            'umkms' => [
                ['name' => 'Dapur Batak', 'detail' => 'Makanan • Balige', 'funding' => 'Pendanaan terbuka', 'thumbnail' => 'from-amber-200 via-orange-300 to-emerald-700', 'emoji' => '🍲'],
                ['name' => 'Kopi Sidikalang Roasters', 'detail' => 'Minuman • Sidikalang', 'funding' => 'Pendanaan terbuka', 'thumbnail' => 'from-stone-800 via-red-900 to-amber-700', 'emoji' => '☕'],
                ['name' => 'Tenun Ulos Sibolga', 'detail' => 'Kerajinan • Sibolga', 'funding' => 'Pendanaan terbuka', 'thumbnail' => 'from-yellow-200 via-orange-300 to-red-500', 'emoji' => '🧵'],
            ],
            'quickActions' => [
                ['label' => 'Jelajah UMKM', 'icon' => 'search', 'iconClass' => 'bg-[#EFF6FF] text-[#2563EB]', 'route' => 'investor.explore'],
                ['label' => 'Tawaran Saya', 'icon' => 'file-text', 'iconClass' => 'bg-[#FFFBEB] text-[#F59E0B]'],
                ['label' => 'Portofolio', 'icon' => 'bar-chart', 'iconClass' => 'bg-[#E6F7F4] text-[#00A88F]'],
                ['label' => 'Return Investasi', 'icon' => 'trending-up', 'iconClass' => 'bg-[#EEF2FF] text-[#4F46E5]'],
            ],
        ]);
    }

    /**
     * Penelusuran UMKM yang sudah terverifikasi, dengan pencarian nama/lokasi
     * dan filter kategori usaha.
     */
    public function explore(Request $request): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'kategori' => ['nullable', 'string', 'max:255'],
        ]);

        $search = $validated['q'] ?? null;
        $category = $validated['kategori'] ?? null;

        $verifiedUmkms = UmkmProfile::query()->where('status_verifikasi', 'verified');

        $umkms = (clone $verifiedUmkms)
            ->when($search, fn (Builder $query, string $search) => $query->where(function (Builder $query) use ($search): void {
                $query->where('nama_usaha', 'like', "%{$search}%")
                    ->orWhere('alamat_usaha', 'like', "%{$search}%");
            }))
            ->when($category, fn (Builder $query, string $category) => $query->where('kategori_usaha', $category))
            ->orderByDesc('terima_investasi')
            ->orderBy('nama_usaha')
            ->get();

        return view('investor.explore', [
            'umkms' => $umkms,
            'categories' => $verifiedUmkms->distinct()->orderBy('kategori_usaha')->pluck('kategori_usaha'),
            'search' => $search,
            'category' => $category,
        ]);
    }
}
