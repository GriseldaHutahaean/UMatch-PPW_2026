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
        Schema::create('investment_offers', function (Blueprint $table) {
            $table->id('offer_id');
            $table->foreignId('investor_profile_id')->constrained('investor_profiles', 'investor_profile_id')->restrictOnDelete();
            $table->foreignId('umkm_profile_id')->constrained('umkm_profiles', 'umkm_profile_id')->restrictOnDelete();
            $table->decimal('jumlah_penawaran', 15, 2);
            $table->string('skema_investasi');
            $table->string('status_penawaran');
            $table->dateTime('tanggal_pengajuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_offers');
    }
};
