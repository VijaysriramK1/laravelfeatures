<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\SmCustomLink;

class CreateSmCustomLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_custom_links', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title1', 255)->nullable();
            $table->string('title2', 255)->nullable();
            $table->string('title3', 255)->nullable();
            $table->string('title4', 255)->nullable();

            $table->string('link_label1', 255)->nullable();
            $table->string('link_href1', 255)->nullable();
            $table->string('link_label2', 255)->nullable();
            $table->string('link_href2', 255)->nullable();
            $table->string('link_label3', 255)->nullable();
            $table->string('link_href3', 255)->nullable();
            $table->string('link_label4', 255)->nullable();
            $table->string('link_href4', 255)->nullable();

            $table->string('link_label5', 255)->nullable();
            $table->string('link_href5', 255)->nullable();
            $table->string('link_label6', 255)->nullable();
            $table->string('link_href6', 255)->nullable();
            $table->string('link_label7', 255)->nullable();
            $table->string('link_href7', 255)->nullable();
            $table->string('link_label8', 255)->nullable();
            $table->string('link_href8', 255)->nullable();

            $table->string('link_label9', 255)->nullable();
            $table->string('link_href9', 255)->nullable();
            $table->string('link_label10', 255)->nullable();
            $table->string('link_href10', 255)->nullable();
            $table->string('link_label11', 255)->nullable();
            $table->string('link_href11', 255)->nullable();
            $table->string('link_label12', 255)->nullable();
            $table->string('link_href12', 255)->nullable();

            $table->string('link_label13', 255)->nullable();
            $table->string('link_href13', 255)->nullable();
            $table->string('link_label14', 255)->nullable();
            $table->string('link_href14', 255)->nullable();
            $table->string('link_label15', 255)->nullable();
            $table->string('link_href15', 255)->nullable();
            $table->string('link_label16', 255)->nullable();
            $table->string('link_href16', 255)->nullable();

            $table->string('facebook_url', 255)->nullable();
            $table->string('twitter_url', 255)->nullable();
            $table->string('dribble_url', 255)->nullable();
            $table->string('linkedin_url', 255)->nullable();
            $table->string('behance_url', 255)->nullable();
            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
            $table->timestamps();
        });


        $s         = new SmCustomLink();
        $s->title1 = 'Departments';
        $s->title2 = 'Health Care';
        $s->title3 = 'About Our System';
        $s->title4 = 'Resources';

        $s->link_label1 = 'About SMA';
        $s->link_href1  = 'http://example.com';

        $s->link_label2 = 'SMA Home';
        $s->link_href2  = 'http://example.com/home';

        $s->link_label3 = 'Business';
        $s->link_href3  = 'http://example.com';

        $s->link_label4 = 'link_label4';
        $s->link_href4  = 'http://example.com';

        $s->link_label5 = 'link_label5';
        $s->link_href5  = 'http://example.com';

        $s->link_label6 = 'link_label6';
        $s->link_href6  = 'http://example.com';

        $s->link_label7 = 'link_label7';
        $s->link_href7  = 'http://example.com';

        $s->link_label8 = 'link_label8';
        $s->link_href8  = 'http://example.com';

        $s->link_label9  = 'Home';
        $s->link_href9   = 'http://example.com/home';

        $s->link_label10 = 'About';
        $s->link_href10  = 'http://example.com/about';


        $s->link_label11 = 'Contact';
        $s->link_href11  = 'http://example.com/contact';

        $s->link_label12 = 'link_label12';
        $s->link_href12  = 'http://example.com';

        $s->link_label13 = 'link_label13';
        $s->link_href13  = 'http://example.com';

        $s->link_label14 = 'link_label14';
        $s->link_href14  = 'http://example.com';

        $s->link_label15 = 'link_label15';
        $s->link_href15  = 'http://example.com';

        $s->link_label16 = 'link_label16';
        $s->link_href16  = 'http://example.com';

        // $s->facebook_url = 'https://www.facebook.com/sgacademy/';
        // $s->twitter_url  = 'https://twitter.com/sgacademy';
        // $s->dribble_url  = 'https://dribbble.com/sgacademy';
        // $s->linkedin_url  = 'https://www.linkedin.com/in/sgacademy/';
        // $s->behance_url  = '';
        $s->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_custom_links');
    }
}
