<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            if (! Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->nullable()->unique()->after('password');
            }

            if (! Schema::hasColumn('users', 'created_at')) {
                $table->timestamps();
            }
        });

        Schema::table('roles', function (Blueprint $table): void {
            if (! Schema::hasColumn('roles', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            if (Schema::hasColumn('users', 'google_id')) {
                $table->dropUnique(['google_id']);
                $table->dropColumn('google_id');
            }

            if (Schema::hasColumn('users', 'created_at')) {
                $table->dropTimestamps();
            }
        });

        Schema::table('roles', function (Blueprint $table): void {
            if (Schema::hasColumn('roles', 'created_at')) {
                $table->dropTimestamps();
            }
        });
    }
};
