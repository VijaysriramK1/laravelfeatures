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
        Schema::create('sm_student_mark_registers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_mark_id')->nullable()->unsigned();
            $table->foreign('student_mark_id')->references('id')->on('sm_student_marks')->onDelete('cascade');
            $table->string('mark_value');
            $table->string('total');
            $table->string('average');
            $table->string('percentage');
            $table->string('grand_total');
            $table->string('grand_percentage');
            $table->string('overall_percpercentage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sm_student_mark_registers');
    }
};
