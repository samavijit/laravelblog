<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

use App\Category;

use App\Photo;

use App\Comment;


use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use Sluggable;

    protected $fillable = ['category_id','photo_id','title','body'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source'    => 'title',
                'onUpdate'  => true
               
            ]
        ];
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }

    public function photo()
    {
    	return $this->belongsTo('App\Photo');
    }

     public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
