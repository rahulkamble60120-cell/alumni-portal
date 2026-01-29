<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Add Department ID (if missing)
            if (!Schema::hasColumn('users', 'department_id')) {
                // We assume institution_id exists, so we place it after that
                $table->unsignedBigInteger('department_id')->nullable()->after('institution_id');
            }

            // 2. Add Chapter ID (if missing)
            if (!Schema::hasColumn('users', 'chapter_id')) {
                $table->unsignedBigInteger('chapter_id')->nullable()->after('department_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['department_id', 'chapter_id']);
        });
    }
};