<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunityNeighboursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_neighbours', function (Blueprint $table) {
            $table->increments('id');
            $table->string('neighbour1_code', 50);
            $table->foreign('neighbour1_code')->references('code')->on('communities');
            $table->string('neighbour2_code', 50);
            $table->foreign('neighbour2_code')->references('code')->on('communities');

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
        Schema::dropIfExists('community_neighbours');
    }
}
