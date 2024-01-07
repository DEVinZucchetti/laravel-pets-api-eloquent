<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessionalsTable extends Migration
{
    public function up()
    {
        Schema::create('professionals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('people_id');
            $table->string('specialty', 50);
            $table->string('register', 20)->nullable();
            $table->timestamps();

            $table->foreign('people_id')->references('id')->on('peoples')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('professionals');
    }
}