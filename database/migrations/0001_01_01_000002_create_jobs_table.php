<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // We use the table name 'jobs' to match the Model 'Job'
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('company');  // Renamed from 'company_name' to match the Controller
            $table->string('location');
            $table->string('type');     // Added 'type' (Full-time/Part-time) for the UI Dropdown
            $table->text('description');
            $table->unsignedBigInteger('user_id')->nullable(); // Who posted it
            $table->unsignedBigInteger('institution_id')->default(1); // Default to 1 for now
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};