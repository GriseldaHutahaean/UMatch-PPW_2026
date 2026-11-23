<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialCategory extends Model
{
    protected $primaryKey = 'fin_category_id';
    public $timestamps = false;
    protected $fillable = ['nama_kategori', 'jenis'];

    public function transactions(): HasMany
    {
        return $this->hasMany(FinancialTransaction::class, 'fin_category_id', 'fin_category_id');
    }
}
