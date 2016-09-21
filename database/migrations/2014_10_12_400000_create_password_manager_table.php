<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_manager', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title')->index();
            $table->string('account_id')->index();
            $table->string('password')->index();
            $table->string('url')->index();
            $table->text('remark');
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
        Schema::drop('password_manager');
    }
}
