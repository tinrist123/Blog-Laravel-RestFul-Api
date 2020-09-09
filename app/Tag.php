<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $table = "tags";

    protected $fillable = ['TagName'];

    public function post()
    {
        return $this->belongsToMany('App\Post', 'posts_have_tags', 'tag_id', 'post_id');
    }
}
