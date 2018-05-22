<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['content','author','comment_count','like','see_count'];

    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function tag(){
        return $this->belongsToMany(Tag::class,'blog_tags','blog_id','tag_id');
    }
}
