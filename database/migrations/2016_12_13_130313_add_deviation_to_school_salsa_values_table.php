<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeviationToSchoolSalsaValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_salsa_values', function (Blueprint $table) {
            $table->renameColumn('deviation_value', 'avg_deviation_value_in_primary_sub');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_salsa_values', function (Blueprint $table) {
            $table->renameColumn('avg_deviation_value_in_primary_sub', 'deviation_value');
        });
    }
}
