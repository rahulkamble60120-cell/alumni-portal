<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id('application_id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('user_id'); // The student
            $table->string('status')->default('pending'); // pending, reviewed, hired
            $table->timestamps();

            // Prevent applying twice to the same job
            $table->unique(['job_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};