<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function class()
    {
        return $this->belongsTo('App\ClassModel');
    }

    public function filling()
    {
        return $this->hasMany('App\Filling');
    }
}
