<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Photo;

class Article extends Model
{
    protected $fillable = ['title','body','photo_id'];

    public function photo()
    {
    	return $this->belongsTo('App\Photo');
    }
    
}


