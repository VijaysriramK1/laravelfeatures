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
        Schema::table('admission_fees_invoice_chields', function (Blueprint $table) {

            $table->dropForeign(['admission_fees_id']);

            $table->renameColumn('admission_fees_id', 'admission_fees_invoice_id');

            $table->foreign('admission_fees_invoice_id')
                  ->references('id')
                  ->on('admission_fees_invoices')
                  ->onDelete('cascade'); 

            $table->string('fees_type',100)->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admission_fees_invoice_chields', function (Blueprint $table) {
            
              $table->dropForeign(['admission_fees_id']);

              $table->renameColumn('admission_fees_id', 'admission_fees_invoice_id');
  
              $table->foreign('admission_fees_invoice_id')
                    ->references('id')
                    ->on('admission_fees_invoices')
                    ->onDelete('cascade'); 

               $table->integer('fees_type')->change();

        });
    }
};
