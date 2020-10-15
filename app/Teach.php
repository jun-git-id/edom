<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teach extends Model
{
    //
    protected $guarded = [];

    public function class()
    {
        return $this->belongsTo('App\ClassModel','kelas_id');
    }

    public function course()
    {
        return $this->belongsTo('App\Course','mata_kuliah_id');
    }

    public function lecturer()
    {
        return $this->belongsTo('App\Lecturer','dosen_id');
    }

    public function academicYear()
    {
        return $this->belongsTo('App\AcademicYear','tahun_akademik_id');
    }

    public function filling()
    {
        return $this->hasMany('App\Filling','mengajar_id');
    }
}
