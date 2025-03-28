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
        Schema::table('sm_classes', function (Blueprint $table) {
            $table->string('image')->nullable(); // Adding the 'image' column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sm_classes', function (Blueprint $table) {
            $table->dropColumn('image'); // Dropping the 'image' column
        });
    }
};
