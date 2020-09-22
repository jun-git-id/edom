<?php

namespace App\Http\Resources;

use App\Custom\CustomFunction;
use Illuminate\Http\Resources\Json\JsonResource;

class DosenPerKelasResourceKelas extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $ipd = $this->class->student->each(function($item, $key){
            $item['nilai'] = $item->filling->where('mengajar_id',$this->id)->first()->fillingDetail->avg('nilai');
        })->avg('nilai');
        return [
            'id' => $this->id,
            'kelas' => $this->class->studyProgram->nama_prodi . $this->class->huruf,
            'matkul' => $this->course->nama_mk,
            'jml_mhs' => $this->class->student->count(),
            'ipd' => $ipd,
            'keterangan' => CustomFunction::ambilKesimpulan($ipd)
        ];
    }
}
