<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Department extends Model
{
    protected $fillable = ['name', 'permissions'];

    public function getPermissionsAttribute($permissions)
    {
        return $this->attributes['permissions'] = unserialize($permissions);
    }
}
