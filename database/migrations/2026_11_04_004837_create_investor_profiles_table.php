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
        Schema::create('investor_profiles', function (Blueprint $table) {
            $table->id('investor_profile_id');
            $table->foreignId('user_id')->unique()->constrained('users', 'user_id')->restrictOnDelete();
            $table->string('nik');
            $table->string('pekerjaan');
            $table->decimal('penghasilan', 15, 2);
            $table->string('jenis_investor');
            $table->string('tingkat_risiko');
            $table->text('tujuan_investasi');
            $table->string('status_verifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_profiles');
    }
};
