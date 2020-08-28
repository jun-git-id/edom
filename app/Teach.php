<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teach extends Model
{
    //
    protected $guarded = [];

    public function classModel()
    {
        return $this->belongsTo('App\ClassModel');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function lecturer()
    {
        return $this->belongsTo('App\Lecturer');
    }

    public function filling()
    {
        return $this->hasMany('App\Filling');
    }
}
