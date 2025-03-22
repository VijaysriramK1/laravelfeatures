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
        Schema::create('attendance_codes', function (Blueprint $table) {
            $table->id();
            $table->uuid('code');
            $table->date('date');
            $table->time('start_at')->nullable();
            $table->time('end_at')->nullable();
            $table->enum('type', ['staff', 'class', 'subject']);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('class_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_codes');
    }
};
