<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MajorChief extends Model
{
    //
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function lecturer()
    {
        return $this->hasOne('App\Lecturer','dosen_id');
    }

    public function major()
    {
        return $this->belongsTo('App\Major','jurusan_id');
    }
}
