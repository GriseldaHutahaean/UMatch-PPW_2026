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
        Schema::create('investments', function (Blueprint $table) {
            $table->id('investment_id');
            $table->foreignId('offer_id')->unique()->constrained('investment_offers', 'offer_id')->restrictOnDelete();
            $table->decimal('nominal', 15, 2);
            $table->dateTime('tanggal_investasi');
            $table->string('status_investasi');
            $table->decimal('return_diterima', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
