<?php

namespace App\Custom;



class CustomFunction
{
    public static function ambilKesimpulan($nilai)
    {
        $kesimpulan = '';

        if($nilai == 4){
            $kesimpulan = 'Baik Sekali';
        }else if($nilai >= 3){
            $kesimpulan = 'Baik';
        }else if($nilai >= 2){
            $kesimpulan = 'Cukup';
        }else if($nilai >= 1){
            $kesimpulan = 'Buruk';
        }

        return $kesimpulan;
    }
}
