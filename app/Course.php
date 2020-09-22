<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    protected $guarded = [];

    public function studyProgram()
    {
        return $this->belongsTo('App\StudyProgram','prodi_id');
    }

    public function teach()
    {
        return $this->hasMany('App\Teach','mata_kuliah_id');
    }
}


