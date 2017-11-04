<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50)->unique();
            $table->string('title', 100)->nullable();
            $table->string('community_code', 50);
            $table->foreign('community_code')->references('code')->on('communities');
            $table->string('community_title', 100)->nullable();
            $table->enum('is_public', ['Kommunal', 'Enskild', 'Landsting'])->nullable()->default('Kommunal');
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('long', 11, 8)->nullable();
            $table->boolean('status')->default(1);
            $table->string('street_address', 150)->nullable();
            $table->string('post_number', 150)->nullable();

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
        Schema::dropIfExists('schools');
    }
}
