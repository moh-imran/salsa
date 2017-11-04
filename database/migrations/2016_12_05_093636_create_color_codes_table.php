<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 250)->nullable();
            $table->string('label', 500)->nullable();
            $table->integer('much_higher_when_greater_than')->nullable();
            $table->integer('above_when_greater_than')->nullable();
            $table->integer('average_when_greater_than')->nullable();
            $table->integer('below_when_less_than')->nullable();
            $table->integer('much_below_when_less_than')->nullable();
            $table->boolean('status')->default(1);

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
        Schema::dropIfExists('color_codes');
    }
}
