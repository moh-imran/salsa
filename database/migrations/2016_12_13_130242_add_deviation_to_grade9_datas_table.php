<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeviationToGrade9DatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grade9_datas', function (Blueprint $table) {
            $table->float('deviation_value', 8, 2)->after('share_ae')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grade9_datas', function (Blueprint $table) {
            $table->dropColumn(['deviation_value']);
        });
    }
}
