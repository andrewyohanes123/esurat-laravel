<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DispositionsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposition_relations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('from_user');
            $table->unsignedBigInteger('to_user');
            $table->unsignedBigInteger('disposition_id');
            $table->unsignedBigInteger('disposition_message_id');
            $table->timestamps();
        });

        Schema::table('disposition_relations', function(Blueprint $table){
            $table->foreign('from_user')->references('id')->on('users');
            $table->foreign('to_user')->references('id')->on('users');
            $table->foreign('disposition_id')->references('id')->on('dispositions');
            $table->foreign('disposition_message_id')->references('id')->on('disposition_messages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dispositions_users');
    }
}
