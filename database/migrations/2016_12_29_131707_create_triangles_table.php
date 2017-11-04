<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrianglesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('triangles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 255)->nullable();
            $table->integer('subject_id')->nullable();
            $table->float('participation_warning_value', 8, 2)->nullable();
            $table->float('merit_points_warning_value', 8, 2)->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('is_free')->default(0);

            $table->integer('created_by')->nullable()->comment('Created by User');
            $table->integer('updated_by')->nullable()->comment('Update by User');
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('triangles');
    }
}
