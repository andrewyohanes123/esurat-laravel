<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disposition extends Model
{
    protected $fillable = ['purpose', 'content', 'description', 'reference_number', 'letter_type_id', 'letter_sort'];

    // protected $with = ['letter_type', 'letter_files'];

    public function letterFiles()
    {
        return $this->hasMany('App\LetterFile');
    }

    public function letterType()
    {
        return $this->belongsTo('App\LetterType');
    }

    public function dispositionRelation()
    {
        return $this->hasOne('App\DispositionRelation');
    }
}
