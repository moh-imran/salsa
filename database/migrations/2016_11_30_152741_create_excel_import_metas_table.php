<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExcelImportMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excel_import_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_key',200)->nullable()->comment('File title');
            $table->string('key',200)->nullable()->comment('File key');
            $table->string('download_url',1000)->nullable()->comment('Download url');
            $table->string('relative_path_on_server',1000)->nullable();
            $table->integer('from_year')->nullable();
            $table->integer('to_year')->nullable();
            $table->string('description',1000)->nullable();
            $table->integer('first_data_row')->nullable()->comment('Row number from where we need to start scrap data');
            $table->integer('file_size')->nullable();
            $table->string('checksum_of_last_file',1000)->nullable()->comment('We will use this to compare two files');
            $table->integer('version_no')->nullable();
            $table->integer('status')->default(1)->comment('1 means pending, 2 means processed, 3 means identical to previous version');

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
        Schema::dropIfExists('excel_import_metas');
    }
}
