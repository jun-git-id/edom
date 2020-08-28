<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fillings', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tgl_pengisian');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('mengajar_id');
            $table->foreign('mahasiswa_id')->references('id')->on('students');
            $table->foreign('mengajar_id')->references('id')->on('teaches');
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
        Schema::dropIfExists('fillings');
    }
}
