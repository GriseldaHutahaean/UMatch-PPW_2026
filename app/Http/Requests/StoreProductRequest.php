<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasRole('umkm') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_produk' => ['required', 'string', 'max:255'],
            'category_id' => ['required', Rule::exists('product_categories', 'category_id')],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'biaya_produksi_per_unit' => ['required', 'numeric', 'min:0'],
            'target_margin' => ['required', 'numeric', 'min:0', 'max:500'],
            'harga' => ['nullable', 'numeric', 'min:0'],
            'jumlah_stok' => ['required', 'integer', 'min:0'],
            'batas_minimum' => ['required', 'integer', 'min:0'],
        ];
    }
}
