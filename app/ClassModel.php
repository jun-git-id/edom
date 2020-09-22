<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $guarded = [];
    protected $table = 'classes';

    public function studyProgram()
    {
        return $this->belongsTo('App\StudyProgram','prodi_id');
    }

    public function teach()
    {
        return $this->hasMany('App\Teach','kelas_id');
    }

    public function student()
    {
        return $this->hasMany('App\Student','kelas_id');
    }
}
