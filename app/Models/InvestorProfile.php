<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvestorProfile extends Model
{
    protected $primaryKey = 'investor_profile_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nik',
        'pekerjaan',
        'penghasilan',
        'jenis_investor',
        'tingkat_risiko',
        'tujuan_investasi',
        'status_verifikasi',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(InvestorDocument::class, 'investor_profile_id', 'investor_profile_id');
    }
}
