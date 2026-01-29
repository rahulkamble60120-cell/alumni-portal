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
            // We removed 'after' to prevent errors if column names differ
            if (!Schema::hasColumn('events', 'department_id')) {
                $table->unsignedBigInteger('department_id')->nullable();
            }
            if (!Schema::hasColumn('events', 'chapter_id')) {
                $table->unsignedBigInteger('chapter_id')->nullable();
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