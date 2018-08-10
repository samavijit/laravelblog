<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\CommentReply;
use App\Post;
use App\User;

class Comment extends Model
{
    protected $fillable = ['post_id','author','email','body','is_active'];

    public function post()
    {
    	return $this->belongsTo('App\Post');
    }

    public function replies()
    {
    	return $this->hasMany('App\CommentReply');
    }
}
