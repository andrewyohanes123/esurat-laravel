<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDispositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispositions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('purpose');
            $table->longText('content');
            $table->longText('description');
            $table->boolean('done')->default(false);
            $table->string('reference_number')->unique();
            $table->bigInteger('letter_type_id')->unsigned();
            $table->enum('letter_sort', ['Surat Keluar', 'Surat Masuk'])->default('Surat Masuk');
            $table->timestamps();
        });

        Schema::table('dispositions', function(Blueprint $table){
            $table->foreign('letter_type_id')->references('id')->on('letter_types');
        });

        Schema::table('letter_files', function(Blueprint $table){
            $table->foreign('disposition_id')->references('id')->on('dispositions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dispositions');
    }
}
