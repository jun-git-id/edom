<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PerDosenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = new DosenPerKelasResource($this);

        $data = collect($data);
        $jml_kls = collect($data['data_per_kelas'])->count();

        return [
            'id' => $data['id'],
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'jumlah_kelas' => $jml_kls,
            'ipk' => $data['ipk'],
            'kesimpulan' => $data['kesimpulan'],
        ];
    }
}
