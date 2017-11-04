<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolPupilTeacherStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_pupil_teacher_stats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('school_code',50);
            $table->foreign('school_code')->references('code')->on('schools');
            $table->integer('students_grade1')->nullable();
            $table->integer('students_grade2')->nullable();
            $table->integer('students_grade3')->nullable();
            $table->integer('students_grade4')->nullable();
            $table->integer('students_grade5')->nullable();
            $table->integer('students_grade6')->nullable();
            $table->integer('students_grade7')->nullable();
            $table->integer('students_grade8')->nullable();
            $table->integer('students_grade9')->nullable();
            $table->float('teachers_count', 11, 2)->nullable();
            $table->float('students_per_teacher', 11, 2)->nullable();
            $table->float('percent_teacher_pedagogical_degree', 11, 2)->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('school_pupil_teacher_stats');
    }
}
