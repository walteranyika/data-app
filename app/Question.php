<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ["title", "answers", "type"];
    //1 GENERAL
    //2 SCHOOL
    //3 OUT OF SCHOOL
    protected $appends = ["answer_count"];

    public function responses()
    {
        return $this->hasMany(Answer::class);
    }

    public function scopeSchool($query)
    {
        return $query->where('type', 1)->orWhere('type', 2);
    }

    public function scopeOut($query)
    {
        return $query->where('type', 1)->orWhere('type', 3);
    }

    public function getAnswerCountAttribute()
    {
        return $this->responses()->count();
    }
}
