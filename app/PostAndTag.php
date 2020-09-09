<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostAndTag extends Model
{
    protected $table = "posts_have_tags";

    protected $fillable = ['post_id', 'tag_id'];
}
