<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSubjectTriangles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('subject_triangles', function($table) {
        $table->boolean('show_participiation_triangle')->nullable()->default(0)->comment('Warning triangle if national test result is > or < than X compared with betygspoäng OR Warning triangle if participation is > X');
        $table->boolean('show_deviation_triangle')->nullable()->default(0)->comment('Warning triangle if national test result is > or < than X compared with betygspoäng OR Warning triangle if participation is > X');
            
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
    }
}
