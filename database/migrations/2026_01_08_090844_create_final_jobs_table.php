<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. FORCE DELETE the old table if it exists
        Schema::dropIfExists('job_posts');

        // 2. CREATE the new table with TEXT column
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id('job_id');
            $table->unsignedBigInteger('institution_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('company_name');
            $table->string('location')->nullable();
            $table->text('description');
            
            // THIS IS THE FIX: TEXT allows unlimited characters
            $table->text('apply_link')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};