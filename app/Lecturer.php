<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    //
    protected $guarded = [];


    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function study_program()
    {
        return $this->belongsTo('App\StudyProgram');
    }

    public function teach()
    {
        return $this->hasMany('App\Teach');
    }
}
