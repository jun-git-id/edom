<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('academic_years')->insert([
            'tahun' => '2019/2020',
            'ganjil_genap' => 'ganjil'
        ]);
        DB::table('academic_years')->insert([
            'tahun' => '2019/2020',
            'ganjil_genap' => 'genap'
        ]);
    }
}
