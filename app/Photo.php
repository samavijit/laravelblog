<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['file'];

    public function getFileAttribute($value)
    {
        return '/images/'.$value;
    }
}
