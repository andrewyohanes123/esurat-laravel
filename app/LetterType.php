<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    protected $fillable = ['name'];

    public function dispositions()
    {
        return $this->hasMany('App\Disposition');
    }
}
