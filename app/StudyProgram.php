<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    //
    protected $guarded = [];

    public function major()
    {
        return $this->belongsTo('App\Major');
    }

    public function class()
    {
        return $this->hasMany('App\ClassModel');
    }

    public function course()
    {
        return $this->hasMany('App\Course');
    }
}
