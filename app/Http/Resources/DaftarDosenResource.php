<?php

namespace App\Http\Resources;

use App\Filling;
use App\Teach;
use Illuminate\Http\Resources\Json\JsonResource;

class DaftarDosenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $kelas_id = $this->class->id;
        $mengajar = Teach::where('kelas_id', $kelas_id)->get();

        $mengajar_arr = [];
        foreach ($mengajar as $mgr) {
            $mengajar_arr[] = [
                'mengajar_id' => $mgr->id,
                'nama_dosen' => $mgr->lecturer->nama,
                'matkul' => $mgr->course->nama_mk,
                'sks' => $mgr->course->sks,
                'status' => $this->status($mgr->id),
            ];
        }

        return [
            'data' => $mengajar_arr
        ];
    }

    public function status($mengajar_id)
    {
        $data = Filling::where([
            'mahasiswa_id' => $this->id,
            'mengajar_id' => $mengajar_id
        ])->first();

        if($data){
            return 'Kuisioner Sudah Diisi';
        }else{
            return 'Kuisioner Belum Diisi';
        }
    }
}
