<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualifyUpperSecDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualify_upper_sec_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('school_code', 50)->comment('Foreign key from school code field');
            $table->foreign('school_code')->references('code')->on('schools');
            $table->float('share_qualify_vocational_program', 11, 2)->nullable()->comment('Share qualified for economy, philosophy and social sciences programmes');
            $table->float('share_qualify_arts_aestetichs_program', 11, 2)->nullable()->comment('Share qualifies for arts & aestetichs programmes');
            $table->float('share_qualify_econ_philos_socialsc_program', 11, 2)->nullable()->comment('Share qualified for economy, philosophy and social sciences programmes');
            $table->float('share_qualify_natural_science_tech_program', 11, 2)->nullable()->comment('Share qualified for natural sciences and technology programmes');
            $table->float('share_not_qualified', 11, 2)->nullable()->comment('Share not qualified');

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
        Schema::dropIfExists('qualify_upper_sec_datas');
    }
}
