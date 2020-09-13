<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blogger extends Model
{
    //
    protected $table = 'blogger';

    protected $fillable = ['Name', 'Email'];

    public function post()
    {
        return $this->hasMany('App\Post', 'user_id', 'id');
    }
}
