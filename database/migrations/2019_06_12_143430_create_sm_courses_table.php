<?php

use App\SmCourse;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('image');
            $table->integer('category_id');
            $table->text('overview')->nullable();
            $table->text('outline')->nullable();
            $table->text('prerequisites')->nullable();
            $table->text('resources')->nullable();
            $table->text('stats')->nullable();
            $table->integer('active_status')->default(1);
            $table->timestamps();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
        });


        $faker = Faker::create();

        $titles = [
            'Creative Writing Workshop',
            'Mathematics Mastery Program', 
            'Coding and Robotics Lab', 
            'Graphic Design Fundamentals', 
            'Data structure and Algorithm'];
        foreach($titles as $key => $title){
            $key++;
            $new = new SmCourse();
            $new->title = $title;
            $new->image = "public/uploads/theme/edulia/course/academic$key.jpg";
            $new->overview = $faker->text(2000);
            $new->outline = $faker->text(2000);
            $new->prerequisites = $faker->text(2000);
            $new->resources = $faker->text(2000);
            $new->stats = $faker->text(2000);
            $new->active_status = 1;
            $new->created_at = date('Y-m-d h:i:s');
            $new->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_courses');
    }
}
