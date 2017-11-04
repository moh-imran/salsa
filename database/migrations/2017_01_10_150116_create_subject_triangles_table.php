<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectTrianglesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_triangles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('school_code',50)->comment('Foreign key from school code field');
            $table->foreign('school_code')->references('code')->on('schools');
            $table->integer('subject_id')->unsigned()->comment('Foreign key from subjects id field');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->boolean('show_triangle')->nullable()->default(0)->comment('Warning triangle if national test result is > or < than X compared with betygspoäng OR Warning triangle if participation is > X');
            $table->integer('created_by')->nullable()->comment('Created by User');
            $table->integer('updated_by')->nullable()->comment('Updated by User');
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
        Schema::dropIfExists('subject_triangles');
    }
}
