<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create 'chapters' table
        if (!Schema::hasTable('chapters')) {
            Schema::create('chapters', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('institution_id')->default(1);
                $table->string('name'); // e.g., "Bangalore Chapter"
                $table->string('city')->nullable();
                $table->timestamps();
            });
        }

        // Create 'departments' table (Just in case it's missing too)
        if (!Schema::hasTable('departments')) {
            Schema::create('departments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('institution_id')->default(1);
                $table->string('name'); // e.g., "Computer Science"
                $table->string('code')->nullable(); // e.g., "CSE"
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('chapters');
        Schema::dropIfExists('departments');
    }
};