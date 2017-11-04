<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommunityCodeInSchoolSalsaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_salsa_values', function (Blueprint $table) {
            $table->string('community_code', 50)->nullable()->after('school_code');
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
            $table->dropColumn('community_code');
        });
    }
}
