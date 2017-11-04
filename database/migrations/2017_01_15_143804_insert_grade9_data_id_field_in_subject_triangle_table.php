<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertGrade9DataIdFieldInSubjectTriangleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subject_triangles', function (Blueprint $table) {
            $table->integer('grade9_data_id')->unsigned()->after('show_triangle')->nullable();
            $table->foreign('grade9_data_id')->references('id')->on('grade9_datas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subject_triangles', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropColumn(['grade9_data_id']);
        });
    }
}
