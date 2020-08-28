<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $guarded = [];

    public function competence()
    {
        return $this->belongsTo('App\Competence');
    }
}
