<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Youth extends Model
{
    protected $guarded=[];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
