<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChildrenTableChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('children_info', function ($table) {
            
            $table->integer('child_1_age')->nullable()->change();
            $table->integer('child_2_age')->nullable()->change();
            $table->integer('child_3_age')->nullable()->change();
            $table->integer('child_4_age')->nullable()->change();
            $table->integer('child_5_age')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
