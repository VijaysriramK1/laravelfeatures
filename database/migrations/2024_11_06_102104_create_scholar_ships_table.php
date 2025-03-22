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
        Schema::create('scholar_ships', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('description')->nullable();
                $table->string('eligibility_criteria')->nullable();
                $table->string('coverage_amount')->nullable();
                $table->enum('coverage_type', ['full', 'percentage', 'fixed'])->nullable();
                $table->json('applicable_fee_ids')->nullable();
                $table->unsignedBigInteger('academic_year_id');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholar_ships');
    }
};
