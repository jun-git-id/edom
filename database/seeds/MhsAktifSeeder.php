<?php

use App\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MhsAktifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mahasiswa = Student::all();

        foreach($mahasiswa as $mhs){
            Student::where('id', $mhs->id)->update([
                'aktif' => '1'
            ]);
        }
    }
}
