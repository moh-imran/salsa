<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalsaValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_salsa_values', function (Blueprint $table) {
            $table->increments('id');
            $table->string('school_code',50);
            $table->foreign('school_code')->references('code')->on('schools');
            $table->decimal('bg_parents_avg_level_of_education')->nullable()->comment('Background Information');
            $table->decimal('bg_share_of_newly_immigrated')->nullable()->comment('Background Information');
            $table->decimal('bg_share_of_born_abroad')->nullable()->comment('Background Information');
            $table->decimal('bg_share_of_foreign_background')->nullable()->comment('Background Information');
            $table->decimal('bg_share_of_boys')->nullable()->comment('Background Information');
            $table->decimal('ga_actual_value_f')->nullable()->comment('Share that have achieved the goals');
            $table->decimal('ga_model_calc_value_b')->nullable()->comment('Share that have achieved the goals');
            $table->decimal('ga_residual_value_f-b')->nullable()->comment('Share that have achieved the goals');
            $table->decimal('amp_actual_value_f')->nullable()->comment('Average Merit Points');
            $table->decimal('amp_model_calc_value_b')->nullable()->comment('Average Merit Points');
            $table->decimal('amp_residual_value_f-b')->nullable()->comment('Average Merit Points');
            $table->decimal('deviation_value')->nullable()->comment('difference between school results and national results');

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
        Schema::dropIfExists('school_salsa_values');
    }
}
