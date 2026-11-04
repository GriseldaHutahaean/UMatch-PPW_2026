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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id('faq_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->restrictOnDelete();
            $table->string('pertanyaan');
            $table->text('jawaban');
            $table->string('kategori');
            $table->string('target_role')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
