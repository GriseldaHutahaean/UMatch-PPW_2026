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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('customer_profile_id')->constrained('customer_profiles', 'customer_profile_id')->restrictOnDelete();
            $table->foreignId('umkm_profile_id')->constrained('umkm_profiles', 'umkm_profile_id')->restrictOnDelete();
            $table->dateTime('tanggal_pesanan');
            $table->decimal('total', 15, 2);
            $table->string('status_pesanan');
            $table->text('alamat_pengiriman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
