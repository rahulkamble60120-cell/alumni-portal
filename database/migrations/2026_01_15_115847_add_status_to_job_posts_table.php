<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_posts', function (Blueprint $table) {
            // Add 'status' column (default to 'active' so old jobs stay visible)
            if (!Schema::hasColumn('job_posts', 'status')) {
                $table->string('status')->default('active'); 
            }
        });
    }

    public function down(): void
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};