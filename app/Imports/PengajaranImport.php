<?php

namespace App\Imports;

use App\ClassModel;
use App\Course;
use App\Lecturer;
use App\Teach;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PengajaranImport implements ToModel, WithHeadingRow
{
    public $tahun_akademik_id;


    public function __construct($tahun_akademik_id) {

        $this->tahun_akademik_id = $tahun_akademik_id;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $dosen = Lecturer::where('nama','like','%'.$row['nama_dosen'].'%')->first();
        $kelas = ClassModel::where([
            'prodi_id' => substr($row['kode_prodi'], 3),
            'huruf' => $row['kelas'],
            'angkatan' => $row['angkatan_kelas']
        ])->first();

        $matkul = Course::where('prodi_id',substr($row['kode_prodi'], 3))->where('nama_mk','like','%'.$row['mata_kuliah'].'%')->first();

        return new Teach([
            'dosen_id' => $dosen->id, //
            'kelas_id' => $kelas->id, //
            'mata_kuliah_id' => $matkul->id, //
            'tahun_akademik_id' => $this->tahun_akademik_id
        ]);
    }
}
