<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->integer('user_id');
            $table->string('avatar')->index()->nullable();
            $table->string('message')->index()->nullable();
            $table->string('tel', 16)->index()->nullable();
            $table->string('zip', 12)->index()->nullable();
            $table->string('address')->index()->nullable();
            $table->string('lat')->index()->nullable();
            $table->string('lon')->index()->nullable();
            $table->string('token', 32)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('profile');
    }
}
