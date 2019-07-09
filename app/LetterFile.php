<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LetterFile extends Model
{
    protected $fillable = ['name', 'file', 'disposition_id', 'type'];

    public function disposition()
    {
        return $this->belongsTo('App\Disposition');
    }
}
