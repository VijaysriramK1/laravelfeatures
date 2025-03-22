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
        Schema::table('student_scholarships', function (Blueprint $table) {

        $table->decimal('scholarship_fees_amount', 9, 2)->after('scholarship_id');
        $table->decimal('amount', 9, 2)->change();
        $table->decimal('stipend_amount', 9, 2)->change();

         });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_scholarships', function (Blueprint $table) {
           
            $table->dropColumn('scholarship_fees_amount');
            $table->decimal('amount', 5, 2)->change();
            $table->decimal('stipend_amount', 5, 2)->change();
            
        });
    
    }
};
