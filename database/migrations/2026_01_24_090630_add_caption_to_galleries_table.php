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
        Schema::table('galleries', function (Blueprint $table) {
            
            // 1. Add 'caption' (The specific error you are seeing)
            if (!Schema::hasColumn('galleries', 'caption')) {
                // We make it nullable so it's optional for the user
                $table->string('caption')->nullable()->after('image_path');
            }

            // 2. Add 'user_id' (Safety check: ensuring this exists too)
            if (!Schema::hasColumn('galleries', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn(['caption', 'user_id']);
        });
    }
};