<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToStipendPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stipend_payments', function (Blueprint $table) {
           
            $table->date('start_date')->nullable();   
            $table->date('end_date')->nullable();     
            $table->decimal('stipends_amount', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stipend_payments', function (Blueprint $table) {
           
            $table->dropColumn(['start_date', 'end_date', 'stipends_amount']);
        });
    }
}
