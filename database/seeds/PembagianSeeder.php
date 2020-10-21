<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembagianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shares')->insert([
            'tanggal' => '2019-07-18 12:00:00',
            'tahun_akademik_id' => '1'
        ]);
        DB::table('shares')->insert([
            'tanggal' => '2019-07-18 12:00:00',
            'tahun_akademik_id' => '2'
        ]);
    }
}
