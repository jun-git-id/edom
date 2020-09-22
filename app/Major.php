<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    //
    protected $guarded = [];


    public function studyProgram()
    {
        return $this->hasMany('App\StudyProgram','jurusan_id');
    }

    public function lecturer()
    {
        return $this->hasMany('App\Lecturer');
    }

    public function majorChief()
    {
        return $this->hasMany('App\MajorChief');
    }
}
