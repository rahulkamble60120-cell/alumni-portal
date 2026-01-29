<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Add columns to link events to specific Chapters or Depts
            if (!Schema::hasColumn('events', 'department_id')) {
                $table->unsignedBigInteger('department_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('events', 'chapter_id')) {
                $table->unsignedBigInteger('chapter_id')->nullable()->after('department_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['department_id', 'chapter_id']);
        });
    }
};