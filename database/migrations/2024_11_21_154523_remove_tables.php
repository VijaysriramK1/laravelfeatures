<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::dropIfExists('sm_book_issues');
        Schema::dropIfExists('sm_library_members');
        Schema::dropIfExists('library_subjects');
        Schema::dropIfExists('sm_books');
        Schema::dropIfExists('sm_book_categories');

        Schema::dropIfExists('sm_room_types');
        Schema::dropIfExists('sm_room_lists');
        Schema::dropIfExists('sm_dormitory_lists');

        Schema::dropIfExists('sm_assign_vehicles');
        Schema::dropIfExists('sm_vehicles');
        Schema::dropIfExists('sm_routes');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::create('sm_books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('book_title', 200)->nullable();
            $table->string('book_number', 200)->nullable();
            $table->string('isbn_no', 200)->nullable();
            $table->string('publisher_name', 200)->nullable();
            $table->string('author_name', 200)->nullable();
            // $table->string('subject',200)->nullable();
            $table->string('rack_number', 50)->nullable();
            $table->integer('quantity')->nullable()->default(0);
            $table->integer('book_price')->nullable();

            $table->date('post_date')->nullable();
            $table->string('details', 500)->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();

            $table->integer('book_subject_id')->nullable()->unsigned();

            $table->integer('book_category_id')->nullable()->unsigned();
            $table->foreign('book_category_id')->references('id')->on('sm_book_categories')->onDelete('cascade');

            $table->integer('created_by')->nullable()->default(1)->unsigned();

            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');

            $table->integer('academic_id')->nullable()->default(1)->unsigned();
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
        });



        Schema::create('sm_book_issues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity')->nullable();
            $table->date('given_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('issue_status')->nullable();
            $table->string('note', 500)->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();

            $table->integer('book_id')->nullable()->unsigned();
            $table->foreign('book_id')->references('id')->on('sm_books')->onDelete('cascade');

            $table->integer('member_id')->nullable()->unsigned();
            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('created_by')->nullable()->default(1)->unsigned();

            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
            
            $table->integer('academic_id')->nullable()->default(1)->unsigned();
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
        });



        Schema::create('sm_library_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('member_ud_id')->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();

            $table->integer('member_type')->nullable()->unsigned();
            $table->foreign('member_type')->references('id')->on('roles')->onDelete('cascade');

            $table->integer('student_staff_id')->nullable()->unsigned();
            $table->foreign('student_staff_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('created_by')->nullable()->default(1)->unsigned();

            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
            
            $table->integer('academic_id')->nullable()->default(1)->unsigned();
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
        });



        Schema::create('library_subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject_name', 255);
            $table->string('sb_category_id', 255)->nullable();
            $table->string('subject_code', 255)->nullable();
            $table->string('subject_type')->default('T');
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();


            $table->integer('created_by')->nullable()->default(1)->unsigned();

            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');

            $table->integer('academic_id')->nullable()->default(1)->unsigned();
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
        });


        Schema::create('sm_book_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_name', 200)->nullable();
            $table->timestamps();
            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
            
            $table->integer('academic_id')->nullable()->default(1)->unsigned();
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
        });


        Schema::create('sm_dormitory_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dormitory_name', 200);
            $table->string('type')->comment('B=Boys, G=Girls');
            $table->string('address')->nullable();
            $table->integer('intake')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();


            $table->integer('created_by')->nullable()->default(1)->unsigned();

            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
            
            $table->integer('academic_id')->nullable()->default(1)->unsigned();
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
        });



        Schema::create('sm_room_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('number_of_bed');
            $table->double('cost_per_bed',16,2)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();

            $table->integer('dormitory_id')->nullable()->default(1)->unsigned();
            $table->foreign('dormitory_id')->references('id')->on('sm_dormitory_lists')->onDelete('cascade');

            $table->integer('room_type_id')->nullable()->default(1)->unsigned();
            $table->foreign('room_type_id')->references('id')->on('sm_room_types')->onDelete('cascade');

            $table->integer('created_by')->nullable()->default(1)->unsigned();

            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
            
            $table->integer('academic_id')->nullable()->default(1)->unsigned();
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
        });



        Schema::create('sm_room_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 255);
            $table->text('description')->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();


            $table->integer('created_by')->nullable()->default(1)->unsigned();

            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
            
            $table->integer('academic_id')->nullable()->default(1)->unsigned();
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
        });
  
        Schema::create('sm_routes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200);
            $table->float('far', 10, 2);
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();

            $table->integer('created_by')->nullable()->default(1)->unsigned();

            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
            
            $table->integer('academic_id')->nullable()->default(1)->unsigned();
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
        });



        Schema::create('sm_vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vehicle_no', 255);
            $table->string('vehicle_model', 255);
            $table->integer('made_year')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();

            $table->integer('driver_id')->nullable()->unsigned();

            $table->integer('created_by')->nullable()->default(1)->unsigned();

            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
            
            $table->integer('academic_id')->nullable()->default(1)->unsigned();
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
        });

        Schema::create('sm_assign_vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();

            $table->integer('vehicle_id')->nullable()->unsigned();
            $table->foreign('vehicle_id')->references('id')->on('sm_vehicles')->onDelete('cascade');

            $table->integer('route_id')->nullable()->unsigned();
            $table->foreign('route_id')->references('id')->on('sm_routes')->onDelete('cascade');

            $table->integer('created_by')->nullable()->default(1)->unsigned();

            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
            
            $table->integer('academic_id')->nullable()->default(1)->unsigned();
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
        });


    }

};
