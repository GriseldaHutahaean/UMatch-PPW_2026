<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UmkmProfile extends Model
{
    protected $primaryKey = 'umkm_profile_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nama_usaha',
        'kategori_usaha',
        'deskripsi',
        'alamat_usaha',
        'kontak_usaha',
        'status_verifikasi',
        'terima_investasi',
    ];

    protected function casts(): array
    {
        return ['terima_investasi' => 'boolean'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(UmkmDocument::class, 'umkm_profile_id', 'umkm_profile_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'umkm_profile_id', 'umkm_profile_id');
    }

    public function financialTransactions(): HasMany
    {
        return $this->hasMany(FinancialTransaction::class, 'umkm_profile_id', 'umkm_profile_id');
    }
}
