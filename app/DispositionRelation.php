<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class DispositionRelation extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'disposition_relations.id' => 5,
            'disposition_relations.from_user' => 5,
            'disposition_relations.to_user' => 5,
            'disposition_relations.disposition_id' => 5,
            'disposition_relations.disposition_message_id' => 5,
        ], 
        'joins' => [
            'dispositions' => ['disposition_relations.disposition_id', 'dispositions.id'],
            'disposition_messages' => ['disposition_relations.disposition_message_id', 'disposition_messages.id'],
            'users' => ['disposition_relations.from_user', 'users.id'],
        ]
    ];

    protected $fillable = ['from_user', 'to_user', 'disposition_id', 'disposition_message_id'];

    // protected $table = 'diposition_relations';

    public function from_user()
    {
        return $this->hasMany(\App\User::class, 'id', 'from_user');
    }

    public function to_user()
    {
        return $this->hasMany(\App\User::class, 'id', 'to_user');
    }

    public function disposition()
    {
        return $this->belongsTo(\App\Disposition::class);
    }

    public function disposition_message()
    {
        return $this->belongsTo(\App\DispositionMessage::class);
    }
}
