<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Institutions Table
        Schema::create('institutions', function (Blueprint $table) {
            $table->id('institution_id'); 
            $table->string('name');
            $table->string('subdomain')->unique(); 
            $table->string('brand_logo')->nullable(); 
            $table->timestamps();
        });

        // 2. Departments Table
        Schema::create('departments', function (Blueprint $table) {
            $table->id('department_id');
            $table->unsignedBigInteger('institution_id'); 
            $table->string('name');
            $table->string('code')->nullable();
            $table->timestamps();

            $table->foreign('institution_id')->references('institution_id')->on('institutions')->onDelete('cascade');
        });

        // 3. Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->unsignedBigInteger('institution_id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('role')->default('student');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('usn')->nullable(); 
            $table->year('graduation_year')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); 
            $table->timestamps();

            $table->foreign('institution_id')->references('institution_id')->on('institutions')->onDelete('cascade');
            $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('institutions');
    }
};