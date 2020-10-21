<?php

namespace App\Imports;

use App\ClassModel;
use App\Student;
use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MhsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = User::create([
            'username' => $row['nim'],
            'email' => $row['email'],
            'password' => Hash::make('password'),
            'role_id' => '2'
        ]);

        $kelas = ClassModel::firstOrCreate([
            'huruf' => $row['kelas'],
            'angkatan' => $row['angkatan'],
            'prodi_id' => substr($row['kode_prodi'], 3)
        ]);

        return new Student([
            'nim' => $row['nim'],
            'nama' => $row['nama_mahasiswa'],
            'aktif' => '1',
            'kelas_id' => $kelas->id,
            'user_id' => $user->id
        ]);
    }
}
