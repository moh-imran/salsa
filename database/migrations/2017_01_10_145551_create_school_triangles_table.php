<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolTrianglesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_triangles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('school_code',50)->comment('Foreign key from school code field');
            $table->foreign('school_code', 'school_code')->references('code')->on('schools');
            $table->integer('triangle_count')->nullable()->default(0)->comment('Warning triangle if total no of warnings triangles below exeeds X');

            $table->integer('created_by')->nullable()->comment('Created by User');
            $table->integer('updated_by')->nullable()->comment('Updated by User');

            $table->unique('school_code', 'unique_school_code');

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

        Schema::table('school_triangles', function (Blueprint $table) {
            $table->dropUnique('unique_school_code');
            $table->dropForeign('school_code');
        });

        Schema::dropIfExists('school_triangles');
    }
}
