<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DispositionRelation extends Model
{
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
