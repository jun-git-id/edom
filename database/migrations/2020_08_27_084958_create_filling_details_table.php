<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFillingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filling_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengisian_id');
            $table->text('pertanyaan');
            $table->string('kompetensi');
            $table->integer('nilai');
            $table->foreign('pengisian_id')->references('id')->on('fillings');
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
        Schema::dropIfExists('filling_details');
    }
}
