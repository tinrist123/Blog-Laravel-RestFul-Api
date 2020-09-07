<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = "posts";

    public function tag()
    {
        return $this->belongsToMany('App\Tag', 'posts_have_tags', 'post_id', 'tag_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'cate_id', 'id');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment', 'post_id', 'id');
    }
}
