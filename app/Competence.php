<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    //
    protected $guarded = [];

    public function question()
    {
        return $this->hasMany('App\Question');
    }
}
