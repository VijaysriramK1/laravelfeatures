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
        Schema::create('scholarships', function (Blueprint $table) {
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

        Schema::create('student_scholarships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('scholarship_id');
            $table->decimal('amount', 5, 2);
            $table->decimal('stipend_amount', 5, 2);
            $table->dateTime('awarded_date');
            $table->timestamps();
        });

        Schema::create('stipends', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('scholarship_id');
            $table->enum('interval_type', ['monthly', 'yearly'])->nullable();
            $table->decimal('amount', 5, 2);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });

        Schema::create('stipend_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('stipend_id');
            $table->enum('payment_method', ['Cash', 'Card', 'Bank Transfer', 'Online'])->nullable();
            $table->decimal('amount', 5, 2);
            $table->dateTime('payment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarships');
        Schema::dropIfExists('student_scholarships');
        Schema::dropIfExists('stipends');
        Schema::dropIfExists('stipend_payments');
    }
};
