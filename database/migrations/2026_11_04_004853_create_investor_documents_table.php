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
        Schema::create('investor_documents', function (Blueprint $table) {
            $table->id('inv_document_id');
            $table->foreignId('investor_profile_id')->constrained('investor_profiles', 'investor_profile_id')->restrictOnDelete();
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
        Schema::dropIfExists('investor_documents');
    }
};
