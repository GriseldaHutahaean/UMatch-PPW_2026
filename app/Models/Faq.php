<?php

namespace App\Models;

use Database\Factories\FaqFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model
{
    /** @use HasFactory<FaqFactory> */
    use HasFactory;

    protected $primaryKey = 'faq_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'pertanyaan',
        'jawaban',
        'kategori',
        'target_role',
    ];

    /**
     * Admin yang mengelola FAQ ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * FAQ umum (tanpa target peran) beserta FAQ khusus peran tersebut.
     *
     * @param  Builder<Faq>  $query
     */
    public function scopeForRole(Builder $query, string $role): void
    {
        $query->where(fn (Builder $query) => $query->whereNull('target_role')->orWhere('target_role', $role));
    }
}
