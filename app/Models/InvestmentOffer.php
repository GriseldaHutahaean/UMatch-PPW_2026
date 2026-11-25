<?php

namespace App\Models;

use Database\Factories\InvestmentOfferFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestmentOffer extends Model
{
    /** @use HasFactory<InvestmentOfferFactory> */
    use HasFactory;

    protected $primaryKey = 'offer_id';

    public $timestamps = false;

    protected $fillable = [
        'investor_profile_id',
        'umkm_profile_id',
        'jumlah_penawaran',
        'skema_investasi',
        'status_penawaran',
        'tanggal_pengajuan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_penawaran' => 'decimal:2',
            'tanggal_pengajuan' => 'datetime',
        ];
    }

    public function investorProfile(): BelongsTo
    {
        return $this->belongsTo(InvestorProfile::class, 'investor_profile_id', 'investor_profile_id');
    }

    public function umkmProfile(): BelongsTo
    {
        return $this->belongsTo(UmkmProfile::class, 'umkm_profile_id', 'umkm_profile_id');
    }
}
