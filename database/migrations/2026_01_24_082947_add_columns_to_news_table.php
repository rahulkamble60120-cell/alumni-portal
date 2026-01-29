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
        Schema::table('news', function (Blueprint $table) {
            
            // 1. Add 'user_id' (This is the MISSING part!)
            if (!Schema::hasColumn('news', 'user_id')) {
                // We add it after 'id' so it sits at the top of the table
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }

            // 2. Add 'category'
            if (!Schema::hasColumn('news', 'category')) {
                $table->string('category')->default('general')->after('content');
            }

            // 3. Add 'image_path'
            if (!Schema::hasColumn('news', 'image_path')) {
                $table->string('image_path')->nullable()->after('category');
            }

            // 4. Add 'slug'
            if (!Schema::hasColumn('news', 'slug')) {
                $table->string('slug')->nullable()->after('title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'category', 'image_path', 'slug']);
        });
    }
};