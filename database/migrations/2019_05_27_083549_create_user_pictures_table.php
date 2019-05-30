<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_pictures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('file');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::table('user_pictures', function (Blueprint $table) {
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_pictures');
    }
}
