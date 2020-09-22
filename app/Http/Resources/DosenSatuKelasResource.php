<?php

namespace App\Http\Resources;

use App\Custom\CustomFunction;
use Illuminate\Http\Resources\Json\JsonResource;

class DosenSatuKelasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $fillingDetail = [];
        foreach($this->filling as $fill){
            foreach($fill->fillingDetail as $fd){
                $fillingDetail[] = $fd;
            }
        }

        $fillingDetail = collect($fillingDetail);
        $kompetensi = $fillingDetail->groupBy('kompetensi');

        $pertanyaan = [];
        foreach($kompetensi as $kmp){
            $pertanyaanKmp = $kmp->groupBy('pertanyaan');
            foreach($pertanyaanKmp as $pert){
                $pertanyaan[] = [
                    'pertanyaan' => $pert->first()->pertanyaan,
                    'ipd' => $pert->avg('nilai'),
                    'kesimpulan' => CustomFunction::ambilKesimpulan($pert->avg('nilai'))
                ];
            }
        }

        return [
            'nik' => $this->lecturer->nidk,
            'nama_dosen' => $this->lecturer->nama,
            'tahun_akademik' => $this->tahun,
            'matkul' => $this->course->nama_mk,
            'kelas' => $this->class->studyProgram->nama_prodi . $this->class->huruf . $this->class->angkatan,
            'responden' => $this->class->student->count(),
            'pertanyaanFinal' => $pertanyaan
        ];
    }
}
