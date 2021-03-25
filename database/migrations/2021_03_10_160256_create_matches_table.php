<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->integer('white');
            $table->foreign('white')->references('id')->on('users')->onDelete('cascade');
            $table->integer('black');
            $table->foreign('black')->references('id')->on('users')->onDelete('cascade');
            $table->integer("result")->nullable();
            $table->integer('round')->nullable();
            $table->integer('table')->nullable();
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
        Schema::dropIfExists('matches');
    }
}
