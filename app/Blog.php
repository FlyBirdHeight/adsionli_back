<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['content','author','comment_count','like','see_count'];

    public function comment(){
        return $this->hasMany(Comment::class)->select('user_id','body','blog_id','created_at')->orderBy('created_at','desc')->with('user');
    }

    public function tag(){
        return $this->belongsToMany(Tag::class,'blog_tags','blog_id','tag_id')->select('id','name');
    }
}
