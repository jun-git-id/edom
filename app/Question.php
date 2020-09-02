<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $guarded = [];
    protected $table = 'questions';

    public function competence()
    {
        return $this->belongsTo('App\Competence','kompetensi_id');
    }
}
