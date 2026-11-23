<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialTransaction extends Model
{
    protected $primaryKey = 'transaction_id';
    public $timestamps = false;
    protected $fillable = ['umkm_profile_id', 'fin_category_id', 'jenis', 'nominal', 'tanggal', 'deskripsi', 'bukti_struk'];

    protected function casts(): array
    {
        return ['nominal' => 'decimal:2', 'tanggal' => 'date'];
    }

    public function umkmProfile(): BelongsTo
    {
        return $this->belongsTo(UmkmProfile::class, 'umkm_profile_id', 'umkm_profile_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(FinancialCategory::class, 'fin_category_id', 'fin_category_id');
    }
}
