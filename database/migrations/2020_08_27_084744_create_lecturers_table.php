<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_induk');
            $table->string('nama');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('prodi_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('prodi_id')->references('id')->on('study_programs');
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
        Schema::dropIfExists('lecturers');
    }
}
