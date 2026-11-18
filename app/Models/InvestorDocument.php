<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestorDocument extends Model
{
    protected $primaryKey = 'inv_document_id';

    public $timestamps = false;

    protected $fillable = ['investor_profile_id', 'jenis_dokumen', 'file_dokumen', 'tanggal_unggah'];

    public function investorProfile(): BelongsTo
    {
        return $this->belongsTo(InvestorProfile::class, 'investor_profile_id', 'investor_profile_id');
    }
}
