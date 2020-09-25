<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = "posts";

    protected $fillable = ['Title', 'Alias', 'Short_Description', 'Content', 'Image', 'cate_id', 'blogger_id', 'created_at', 'updated_at'];

    public function tag()
    {
        return $this->belongsToMany('App\Tag', 'posts_have_tags', 'post_id', 'tag_id');
    }
    public function blogger()
    {
        return $this->belongsTo('App\Blogger', 'blogger_id', 'id');
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
