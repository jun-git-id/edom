<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


//SELURUH PENGISIAN YANG DILAKUKAN MAHASISWA
class PerMahasiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id_mhs' => $this->student->nim,
            'kelas' => $this->student->class->studyProgram->nama_prodi . $this->student->class->huruf,
            'tahun_akademik' => $this->teach->tahun,
            'mata_kuliah' => $this->teach->course->nama_mk,
            'dosen' => $this->teach->lecturer->nama,
            'ip' => $this->fillingDetail->avg('nilai')

        ];
    }
}
