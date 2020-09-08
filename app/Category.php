<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = "category";

    protected $fillable = ['id', 'CateName', 'Alias'];

    public function post()
    {
        return $this->hasMany('App\Post', 'cate_id', 'id');
    }
}
