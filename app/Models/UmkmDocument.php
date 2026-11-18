<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UmkmDocument extends Model
{
    protected $primaryKey = 'document_id';

    public $timestamps = false;

    protected $fillable = ['umkm_profile_id', 'jenis_dokumen', 'file_dokumen', 'tanggal_unggah'];

    public function umkmProfile(): BelongsTo
    {
        return $this->belongsTo(UmkmProfile::class, 'umkm_profile_id', 'umkm_profile_id');
    }
}
