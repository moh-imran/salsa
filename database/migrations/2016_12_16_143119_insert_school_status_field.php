<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertSchoolStatusField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grade9_datas', function (Blueprint $table) {
            $table->boolean('school_status')->default(1);
        });
        Schema::table('national_results_datas', function (Blueprint $table) {
            $table->boolean('school_status')->default(1);
        });
        Schema::table('qualify_upper_sec_datas', function (Blueprint $table) {
            $table->boolean('school_status')->default(1);
        });
        Schema::table('school_salsa_values', function (Blueprint $table) {
            $table->boolean('school_status')->default(1);
        });
        Schema::table('school_pupil_teacher_stats', function (Blueprint $table) {
            $table->boolean('school_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('grade9_datas', function ($table) {
            $table->dropColumn('school_status');
        });
        Schema::table('national_results_datas', function ($table) {
            $table->dropColumn('school_status');
        });
        Schema::table('qualify_upper_sec_datas', function ($table) {
            $table->dropColumn('school_status');
        });
        Schema::table('school_salsa_values', function ($table) {
            $table->dropColumn('school_status');
        });
        Schema::table('school_pupil_teacher_stats', function ($table) {
            $table->dropColumn('school_status');
        });
    }
}
