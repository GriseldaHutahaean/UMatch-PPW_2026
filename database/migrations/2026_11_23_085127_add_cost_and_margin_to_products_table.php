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
        Schema::table('products', function (Blueprint $table): void {
            $table->decimal('biaya_produksi_per_unit', 15, 2)->default(0)->after('harga');
            $table->decimal('target_margin', 5, 2)->default(30)->after('biaya_produksi_per_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->dropColumn(['biaya_produksi_per_unit', 'target_margin']);
        });
    }
};
