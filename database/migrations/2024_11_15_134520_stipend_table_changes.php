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
        Schema::table('stipends', function (Blueprint $table) {
            $table->string('amount')->nullable()->change();
            $table->string('interval_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stipends', function (Blueprint $table) {
            $table->decimal('amount', 5, 2)->change();
            $table->enum('interval_type', ['monthly', 'yearly'])->nullable()->change();
        });
    }
};
