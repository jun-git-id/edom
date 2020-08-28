<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FillingDetail extends Model
{
    //
    protected $guarded = [];

    public function filling()
    {
        return $this->belongsTo('App\Filling');
    }
}
