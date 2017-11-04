<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnsInColorCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('color_codes', function (Blueprint $table) {

            $table->float('much_higher_when_greater_than', 8, 2)->change();
            $table->float('above_when_greater_than', 8, 2)->change();
            $table->float('average_when_greater_than', 8, 2)->change();
            $table->float('below_when_less_than', 8, 2)->change();
            $table->float('much_below_when_less_than', 8, 2)->change();
            $table->boolean('is_free')->default(0)->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('color_codes', function (Blueprint $table) {
            $table->dropColumn('is_free');
        });
    }
}
