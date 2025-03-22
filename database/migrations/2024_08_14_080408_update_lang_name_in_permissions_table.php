<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        DB::table('permissions')
            ->where('name', 'Admission Fees invoice')
            ->update(['lang_name' => 'Admission Fees Invoice']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      
        DB::table('permissions')
            ->where('name', 'Admission Fees invoice')
            ->update(['lang_name' => 'Admission Fees ivoice']);
    }
};
