<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->foreignId('category_id')->constrained('product_categories', 'category_id')->restrictOnDelete();
            $table->foreignId('umkm_profile_id')->constrained('umkm_profiles', 'umkm_profile_id')->restrictOnDelete();
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 15, 2);
            $table->string('foto')->nullable();
            $table->string('status_produk');
            $table->unsignedInteger('jumlah_stok')->default(0);
            $table->unsignedInteger('batas_minimum')->default(0);
            $table->string('status_moderasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
