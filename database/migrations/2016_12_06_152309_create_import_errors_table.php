<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_errors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('table_name', 500)->nullable();
            $table->string('missing_table_name', 500)->nullable();
            $table->string('community_code', 50)->nullable();
            $table->string('community_title', 2000)->nullable();
            $table->string('school_code', 50)->nullable();
            $table->string('school_title', 2000)->nullable();
            $table->boolean('status')->nullable()->default(1)->comment('We can use it to check whether processed by admin or not');

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
        Schema::dropIfExists('import_errors');
    }
}
