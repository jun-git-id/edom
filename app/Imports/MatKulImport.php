<?php

namespace App\Imports;

use App\Course;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MatKulImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Course([
            'nama_mk' => $row['nama_mata_kuliah'],
            'sks' => $row['sks'],
            'semester' => $row['semester'],
            'prodi_id' => substr($row['kode_prodi'], 3)
        ]);
    }
}
