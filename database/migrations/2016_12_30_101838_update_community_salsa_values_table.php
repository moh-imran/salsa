<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCommunitySalsaValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('community_salsa_values', function (Blueprint $table) {
            $table->string('min_school_code', 100)->nullable()->after('community_title');
            $table->float('min_amp_residual_value', 8, 2)->nullable()->after('min_school_code');
            $table->string('max_school_code', 100)->nullable()->after('min_amp_residual_value');
            $table->float('max_amp_residual_value', 8, 2)->nullable()->after('max_school_code');

            $table->foreign('min_school_code')->references('code')->on('schools');
            $table->foreign('max_school_code')->references('code')->on('schools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('community_salsa_values', function (Blueprint $table) {
            $table->dropForeign(['min_school_code']);
            $table->dropForeign(['max_school_code']);
            $table->dropColumn('min_school_code');
            $table->dropColumn('min_amp_residual_value');
            $table->dropColumn('max_school_code');
            $table->dropColumn('max_amp_residual_value');
        });
    }
}
