<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Disposition extends Model
{
    use SearchableTrait;

    protected $fillable = [
        'purpose', 
        'content', 
        'description', 
        'reference_number', 
        'letter_type_id', 
        'letter_sort', 
        'from_user', 
        'last_user', 
        'send_to'
    ];

    protected $searchable = [
        'columns' => [
            'dispositions.reference_number' => 10,
            'dispositions.content' => 9,
            'dispositions.description' => 9,
            'dispositions.send_to' => 9,
            'dispositions.letter_sort' => 9,
            'dispositions.purpose' => 9,
        ]
    ];

    // protected $with = ['letter_type', 'letter_files'];

    public function letterFiles()
    {
        return $this->hasMany(\App\LetterFile::class, 'disposition_id', 'id');
    }

    public function letterType()
    {
        return $this->belongsTo('App\LetterType');
    }

    public function dispositionRelation()
    {
        return $this->hasOne('App\DispositionRelation');
    }

    public function lastUser()
    {
        return $this->belongsTo('App\User', 'last_user', 'id');
    }

    public function fromUser()
    {
        return $this->belongsTo('App\User');
    }
}
