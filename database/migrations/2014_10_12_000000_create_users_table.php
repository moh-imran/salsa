<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('email', 150)->unique();
            $table->string('password')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('auth_token', 50)->nullable();
            $table->string('subscription_profile_id', 50)->nullable();
            $table->boolean('status')->default(1);
            $table->rememberToken();
            $table->string('active_code', 40)->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            
            // fileds for stripe 
            $table->string('stripe_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            
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
        Schema::dropIfExists('users');
    }
}
