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
        Schema::create('sm_admission_queries_reminders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('reminder_at');
            $table->text('reminder_notes')->nullable();
            $table->boolean('is_notify')->default(false);
            $table->unsignedTinyInteger('status')->default(2);
            $table->timestamps();

            $table->integer('admission_query_id')->nullable()->unsigned();
            $table->foreign('admission_query_id')->references('id')->on('sm_admission_queries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sm_admission_queries_reminders');
    }
};
