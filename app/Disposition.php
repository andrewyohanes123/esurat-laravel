<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disposition extends Model
{
    protected $fillable = ['purpose', 'content', 'description', 'reference_number',];

    public function users()
    {
        return $this->belongsToMany(\App\User::class);
    }

    public function letterFiles()
    {
        return $this->hasMany(\App\LetterFile::class);
    }

    public function letterType()
    {
        return $this->hasOne(\App\LetterType::class);
    }
}
