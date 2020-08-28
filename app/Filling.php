<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filling extends Model
{
    //
    protected $guarded = [];


    public function student()
    {
        return $this->belongsTo('App\Student');
    }

    public function teach()
    {
        return $this->belongsTo('App\Teach');
    }

    public function fillingDetail()
    {
        return $this->hasMany('App\FillingDetail');
    }
}
