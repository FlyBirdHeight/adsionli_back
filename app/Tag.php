<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name','count'];

    public function blog(){
        return $this->belongsToMany(Blog::class,'blog_tags','tag_id');
    }
}
