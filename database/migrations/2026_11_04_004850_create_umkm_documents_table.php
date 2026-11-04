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
        Schema::create('umkm_documents', function (Blueprint $table) {
            $table->id('document_id');
            $table->foreignId('umkm_profile_id')->constrained('umkm_profiles', 'umkm_profile_id')->restrictOnDelete();
            $table->string('jenis_dokumen');
            $table->string('file_dokumen');
            $table->dateTime('tanggal_unggah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_documents');
    }
};
