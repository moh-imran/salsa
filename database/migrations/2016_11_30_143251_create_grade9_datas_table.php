<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrade9DatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade9_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('school_code',50)->comment('Foreign key from school code field');
            $table->foreign('school_code')->references('code')->on('schools');
            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->integer('students_enrolled')->nullable()->comment('Students in grade 9');
            $table->float('merit_points', 11, 2)->nullable()->comment('Merit points earned 20 Max. 2.5 points depreciated as grade move down one place. A = 20, B = 17.5');
            $table->float('share_ae', 11, 2)->nullable()->comment('Percentage of students with Grades between A and E');

            $table->integer('created_by')->nullable()->comment('Created by User');
            $table->integer('updated_by')->nullable()->comment('Update by User');
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
        Schema::dropIfExists('grade9_datas');
    }
}
