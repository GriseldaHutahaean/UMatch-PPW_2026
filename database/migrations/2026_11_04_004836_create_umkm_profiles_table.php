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
        Schema::create('umkm_profiles', function (Blueprint $table) {
            $table->id('umkm_profile_id');
            $table->foreignId('user_id')->unique()->constrained('users', 'user_id')->restrictOnDelete();
            $table->string('nama_usaha');
            $table->string('kategori_usaha');
            $table->text('deskripsi')->nullable();
            $table->text('alamat_usaha')->nullable();
            $table->string('kontak_usaha')->nullable();
            $table->string('status_verifikasi');
            $table->boolean('terima_investasi')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_profiles');
    }
};
