<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Disposition extends Model
{
    use SearchableTrait;

    protected $fillable = ['purpose', 'content', 'description', 'reference_number', 'letter_type_id', 'letter_sort', 'from_user', 'last_user'];

    protected $searchable = [
        'columns' => [
            'dispositions.reference_number' => 10,
            'dispositions.content' => 9,
            'dispositions.letter_sort' => 9,
            'dispositions.purpose' => 9,
        ],
        'joins' => [
            'letter_types' => ['dispositions.letter_type_id', 'letter_types.id'],
            // 'disposition_messages' => ['disposition_messages.disposition_id', 'dispositions.id'],
            'letter_files' => ['letter_files.disposition_id', 'dispositions.id']
        ]
    ];

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

    public function lastUser()
    {
        return $this->belongsTo('App\User', 'last_user', 'id');
    }

    public function fromUser()
    {
        return $this->belongsTo('App\User');
    }
}
