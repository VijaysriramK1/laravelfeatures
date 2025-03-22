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
        Schema::table('student_records', function (Blueprint $table) {
            $table->unsignedBigInteger('admission_fees_id')->nullable()->after('student_id');

            // Add foreign key constraint if needed
            $table->foreign('admission_fees_id')->references('id')->on('admission_fees')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_records', function (Blueprint $table) {
            $table->dropForeign(['admission_fees_id']);
            
            // Drop the column
            $table->dropColumn('admission_fees_id');

        });
    }
};
