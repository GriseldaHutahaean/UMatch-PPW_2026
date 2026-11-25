<?php

namespace App\Http\Controllers;

use App\Models\InvestmentOffer;
use App\Models\UmkmProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
                ['label' => 'Total Investasi', 'value' => 'Rp 125 juta', 'change' => '+8%', 'iconClass' => 'bg-[#EAF1FA] text-[#1E4E8C]'],
                ['label' => 'UMKM Didanai', 'value' => '3', 'change' => '+1', 'iconClass' => 'bg-[#E6F7F4] text-[#00A88F]'],
                ['label' => 'Return Investasi', 'value' => '14,2%', 'change' => '+2,1', 'iconClass' => 'bg-[#E6F7F4] text-[#00A88F]'],
                ['label' => 'Portofolio Aktif', 'value' => '3', 'change' => 'Aktif', 'iconClass' => 'bg-[#FFF1EB] text-[#FF7043]'],
            ],
            'allocations' => [
                ['name' => 'Dapur Batak', 'amount' => 'Rp 50.000.000', 'percentage' => 40, 'barClass' => 'bg-[#00A88F]', 'textClass' => 'text-[#00A88F]'],
                ['name' => 'Batik Toba', 'amount' => 'Rp 30.000.000', 'percentage' => 24, 'barClass' => 'bg-[#FF7043]', 'textClass' => 'text-[#FF7043]'],
                ['name' => 'Kerajinan Nusantara', 'amount' => 'Rp 45.000.000', 'percentage' => 36, 'barClass' => 'bg-[#1E4E8C]', 'textClass' => 'text-[#1E4E8C]'],
            ],
            'umkms' => [
                ['name' => 'Dapur Batak', 'detail' => 'Kuliner • Rp 45jt/bln'],
                ['name' => 'Batik Toba', 'detail' => 'Fashion • Rp 32jt/bln'],
                ['name' => 'Kerajinan Nusantara', 'detail' => 'Kerajinan • Rp 28jt/bln'],
            ],
            'offers' => [
                ['name' => 'Dapur Batak', 'detail' => 'Rp 50 juta • 15% ekuitas • 20 Nov 2026', 'status' => 'Menunggu', 'statusClass' => 'bg-[#FFFBEB] text-[#D97706]'],
                ['name' => 'Batik Toba', 'detail' => 'Rp 30 juta • 10% ekuitas • 10 Nov 2026', 'status' => 'Diterima', 'statusClass' => 'bg-[#ECFDF5] text-[#10B981]'],
                ['name' => 'Kerajinan Nusantara', 'detail' => 'Rp 15 juta • 5% ekuitas • 02 Nov 2026', 'status' => 'Ditolak', 'statusClass' => 'bg-[#FEF2F2] text-[#EF4444]'],
            ],
            'menus' => [
                ['label' => 'Jelajahi UMKM', 'icon' => 'search', 'iconClass' => 'bg-[#EAF1FA] text-[#1E4E8C]', 'route' => 'investor.explore'],
                ['label' => 'Portofolio', 'icon' => 'briefcase', 'iconClass' => 'bg-[#E6F7F4] text-[#00A88F]'],
                ['label' => 'Tawaran Saya', 'icon' => 'file-text', 'iconClass' => 'bg-[#FFFBEB] text-[#F59E0B]', 'route' => 'investor.offers'],
                ['label' => 'Verifikasi KYC', 'icon' => 'shield', 'iconClass' => 'bg-[#E6F7F4] text-[#00A88F]'],
                ['label' => 'Bantuan', 'icon' => 'help-circle', 'iconClass' => 'bg-[#FFF1EB] text-[#FF7043]'],
            ],
        ]);
    }

    /**
     * Penelusuran UMKM yang sudah terverifikasi, dengan pencarian nama/lokasi,
     * filter kategori usaha, dan omzet bulan berjalan dari pencatatan keuangan UMKM.
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
            ->withSum(['financialTransactions as monthly_revenue' => fn (Builder $query) => $query
                ->where('jenis', 'pemasukan')
                ->whereDate('tanggal', '>=', now()->startOfMonth())
                ->whereDate('tanggal', '<=', now()->endOfMonth())], 'nominal')
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

    /**
     * Daftar tawaran investasi milik investor yang sedang login, dengan filter status.
     */
    public function offers(Request $request): View
    {
        $validated = $request->validate([
            'status' => ['nullable', 'string', Rule::in(['menunggu', 'diterima', 'ditolak'])],
        ]);

        $status = $validated['status'] ?? null;

        $allOffers = InvestmentOffer::query()
            ->with('umkmProfile')
            ->whereRelation('investorProfile', 'user_id', $request->user()->getKey())
            ->latest('tanggal_pengajuan')
            ->get();

        return view('investor.offers', [
            'offers' => $status ? $allOffers->where('status_penawaran', $status) : $allOffers,
            'totalOffers' => $allOffers->count(),
            'statusCounts' => $allOffers->countBy('status_penawaran'),
            'status' => $status,
        ]);
    }
}
