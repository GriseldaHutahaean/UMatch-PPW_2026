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
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->foreignId('umkm_profile_id')->constrained('umkm_profiles', 'umkm_profile_id')->restrictOnDelete();
            $table->foreignId('fin_category_id')->constrained('financial_categories', 'fin_category_id')->restrictOnDelete();
            $table->string('jenis');
            $table->decimal('nominal', 15, 2);
            $table->date('tanggal');
            $table->text('deskripsi')->nullable();
            $table->string('bukti_struk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
