<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DispositionMessage extends Model
{
    protected $fillable = ['user_id', 'message'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
