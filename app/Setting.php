<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function Opis\Closure\unserialize;

class Setting extends Model
{
    protected $fillable = ['users_allow_create_disposition', 'users_allow_create_outbox'];

    public function getUsersAllowCreateDispositionAttribute($setting)
    {
        return $this->attributes['users_allow_create_disposition'] = unserialize($setting);
    }

    public function getUsersAllowCreateOutboxAttribute($setting)
    {
        return $this->attributes['users_allow_create_outbox'] = unserialize($setting);
    }
}
