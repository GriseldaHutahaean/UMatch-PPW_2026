<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    public $timestamps = false;
    protected $fillable = ['category_id', 'umkm_profile_id', 'nama_produk', 'deskripsi', 'harga', 'biaya_produksi_per_unit', 'target_margin', 'foto', 'status_produk', 'jumlah_stok', 'batas_minimum', 'status_moderasi'];

    protected function casts(): array
    {
        return ['harga' => 'decimal:2', 'biaya_produksi_per_unit' => 'decimal:2', 'target_margin' => 'decimal:2'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'category_id');
    }

    public function umkmProfile(): BelongsTo
    {
        return $this->belongsTo(UmkmProfile::class, 'umkm_profile_id', 'umkm_profile_id');
    }
}
