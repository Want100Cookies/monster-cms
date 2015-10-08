<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageAndBlockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('enabled');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            
            $table->timestamps();
        });

        Schema::create('block', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('type');
            $table->json('content');
            $table->string('class');
            $table->boolean('enabled');

            $table->integer('page_id')->unsigned();
            $table->foreign('page_id')
                  ->references('id')->on('page')
                  ->onDelete('cascade');

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
        Schema::drop('block');

        Schema::drop('page');
    }
}
