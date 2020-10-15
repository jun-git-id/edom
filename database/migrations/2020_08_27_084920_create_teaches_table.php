<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teaches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('mata_kuliah_id');
            $table->unsignedBigInteger('tahun_akademik_id');
            $table->foreign('dosen_id')->references('id')->on('lecturers');
            $table->foreign('kelas_id')->references('id')->on('classes');
            $table->foreign('mata_kuliah_id')->references('id')->on('courses');
            $table->foreign('tahun_akademik_id')->references('id')->on('academic_years');
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
        Schema::dropIfExists('teaches');
    }
}
