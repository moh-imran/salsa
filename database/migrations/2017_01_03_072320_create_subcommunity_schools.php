<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcommunitySchools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcummunity_schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('community_code', 50)->nullable();
            $table->string('school_code', 50)->nullable();
            //$table->foreign('school_code')->references('code')->on('schools');
            $table->foreign('community_code')->references('code')->on('communities');

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
        Schema::dropIfExists('subcummunity_schools');
    }
}
