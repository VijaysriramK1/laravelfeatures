<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sm_admission_query_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('file_path');
            $table->unsignedTinyInteger('status')->default(2);
            $table->timestamps();

            $table->integer('admission_query_id')->nullable()->unsigned();
            $table->foreign('admission_query_id')->references('id')->on('sm_admission_queries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('sm_admission_query_attachments');
    }
};
