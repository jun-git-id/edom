<?php

namespace App\Imports;

use App\Lecturer;
use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = User::create([
            'username' => $row['nip_npak_atau_nidn'],
            'email' => $row['email'],
            'password' => Hash::make('password'),
            'role_id' => '3'
        ]);


        return new Lecturer([
            'nomor_induk' => $row['nip_npak_atau_nidn'],
            'nama' => $row['nama_dosen'],
            'user_id' => $user->id,
            'prodi_id' => substr($row['kode_prodi'], 3)
        ]);
    }
}
