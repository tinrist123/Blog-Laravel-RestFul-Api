<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    //
    protected $table = 'users';


    public function comment()
    {
        return $this->hasMany('App\Comment', 'user_id', 'id');
    }

    public function post()
    {
        return $this->hasMany('App\Post', 'user_id', 'id');
    }
}
