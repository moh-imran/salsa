<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunitySalsaValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_salsa_values', function (Blueprint $table) {
            $table->increments('id');
            $table->string('community_code', 50);
            $table->foreign('community_code')->references('code')->on('communities');
            $table->string('community_title', 100)->nullable();
            $table->decimal('ga_actual_value_avg_three_yrs')->nullable();
            $table->decimal('ga_model_calc_value_avg_three_yrs')->nullable();
            $table->decimal('ga_residual_value_avg_three_yrs')->nullable();
            $table->decimal('amp_actual_value_avg_three_yrs')->nullable();
            $table->decimal('amp_model_calc_value_avg_three_yrs')->nullable();
            $table->decimal('amp_residual_value_avg_three_yrs')->nullable();
            $table->decimal('public_ga_actual_value_avg_three_yrs')->nullable();
            $table->decimal('public_ga_model_calc_value_avg_three_yrs')->nullable();
            $table->decimal('public_ga_residual_value_avg_three_yrs')->nullable();
            $table->decimal('public_amp_actual_value_avg_three_yrs')->nullable();
            $table->decimal('public_amp_model_calc_value_avg_three_yrs')->nullable();
            $table->decimal('public_amp_residual_value_avg_three_yrs')->nullable();

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
        Schema::dropIfExists('community_salsa_values');
    }
}
