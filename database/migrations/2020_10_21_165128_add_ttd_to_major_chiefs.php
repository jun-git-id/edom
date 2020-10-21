<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTtdToMajorChiefs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('major_chiefs', function (Blueprint $table) {
            $table->string('ttd');
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
            $table->dropColumn('ttd');
        });
    }
}
