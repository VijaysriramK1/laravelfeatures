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
        DB::table('sm_header_menu_managers')->insert([
            'type' => 'sPages',
            'element_id' => 1,
            'title' => 'Home',
            'link' => '/',
            'position' => 387437,
            'show' => 0,
            'is_newtab' => 0,
            'theme' => 'default',
            'school_id' => 1,
        ]);
        DB::table('sm_header_menu_managers')->insert([
            'type' => 'sPages',
            'element_id' => 2,
            'title' => 'About',
            'link' => '/about',
            'position' => 387437,
            'show' => 0,
            'is_newtab' => 0,
            'theme' => 'default',
            'school_id' => 1,
        ]);
        DB::table('sm_header_menu_managers')->insert([
            'type' => 'sPages',
            'element_id' => 3,
            'title' => 'Course',
            'link' => '/course',
            'position' => 387437,
            'show' => 0,
            'is_newtab' => 0,
            'theme' => 'default',
            'school_id' => 1,
        ]);
        DB::table('sm_header_menu_managers')->insert([
            'type' => 'sPages',
            'element_id' => 4,
            'title' => 'News',
            'link' => '/news-page',
            'position' => 387437,
            'show' => 0,
            'is_newtab' => 0,
            'theme' => 'default',
            'school_id' => 1,
        ]);

        DB::table('sm_header_menu_managers')->insert([
            'type' => 'sPages',
            'element_id' => 5,
            'title' => 'Contact',
            'link' => '/contact',
            'position' => 387437,
            'show' => 0,
            'is_newtab' => 0,
            'theme' => 'default',
            'school_id' => 1,
        ]);
        DB::table('sm_header_menu_managers')->insert([
            'type' => 'sPages',
            'element_id' => 6,
            'title' => 'Login',
            'link' => '/login',
            'position' => 387437,
            'show' => 0,
            'is_newtab' => 0,
            'theme' => 'default',
            'school_id' => 1,
        ]);
        DB::table('sm_header_menu_managers')->insert([
            'type' => 'sPages',
            'element_id' => 7,
            'title' => 'Result',
            'link' => '/exam-result',
            'position' => 387437,
            'show' => 0,
            'is_newtab' => 0,
            'theme' => 'default',
            'school_id' => 1,
        ]);
        DB::table('sm_header_menu_managers')->insert([
            'type' => 'sPages',
            'element_id' => 8,
            'title' => 'Routine',
            'link' => '/class-exam-routine',
            'position' => 387437,
            'show' => 0,
            'is_newtab' => 0,
            'theme' => 'default',
            'school_id' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_menu');
    }
};
