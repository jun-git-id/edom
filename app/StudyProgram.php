<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    //
    protected $guarded = [];

    public function major()
    {
        return $this->belongsTo('App\Major','jurusan_id');
    }

    public function class()
    {
        return $this->hasMany('App\ClassModel','prodi_id');
    }

    public function course()
    {
        return $this->hasMany('App\Course','prodi_id');
    }

    public function lecturer()
    {
        return $this->hasMany('App\Lecturer','prodi_id');
    }
}
