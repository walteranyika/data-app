<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable=["user_id","youth_id","question_id","value"];

    public function question()
    {
       return $this->belongsTo(Question::class) ;
    }

    public function youth()
    {
      return $this->belongsTo(Youth::class);
    }
}
