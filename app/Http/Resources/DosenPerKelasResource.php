<?php

namespace App\Http\Resources;

use App\Custom\CustomFunction;
use Illuminate\Http\Resources\Json\JsonResource;

use function Symfony\Component\VarDumper\Dumper\esc;

//SATU DOSEN BANYAK KELAS
class DosenPerKelasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /* return [
            'kelas' => $this->teach->class->studyProgram->nama_prodi . $this->teach->class->huruf,
            'matkul' => $this->teach->course->nama_mk,
            'jml_mhs' => ,
            'ipd' => '',
            'keterangan' => ''
        ]; */

        $dataPerKelas = DosenPerKelasResourceKelas::collection($this->teach);
        $ipk = collect($dataPerKelas->jsonSerialize())->avg('ipd');

        return [
            'id' => $this->id,
            'nik' => $this->nidk,
            'nama' => $this->nama,
            'tahun_akademik' => $this->teach[0]->tahun,
            'tgl_pengisian' => $this->teach[0]->filling[0]->tgl_pengisian,
            'data_per_kelas' => $dataPerKelas,
            'ipk' => $ipk,
            'kesimpulan' => CustomFunction::ambilKesimpulan($ipk)
        ];
    }

}
