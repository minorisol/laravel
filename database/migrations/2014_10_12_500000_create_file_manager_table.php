<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_manager', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title')->index();
            $table->string('file_path')->index();
            $table->string('token')->index();
            $table->string('password')->index();
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
        Schema::drop('file_manager');
    }
}
