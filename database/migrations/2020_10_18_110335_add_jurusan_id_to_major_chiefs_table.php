<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJurusanIdToMajorChiefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('major_chiefs', function (Blueprint $table) {
            $table->unsignedBigInteger('jurusan_id');
            $table->foreign('jurusan_id')->references('id')->on('majors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('major_chiefs', function (Blueprint $table) {
            $table->dropColumn('jurusan_id');
        });
    }
}
