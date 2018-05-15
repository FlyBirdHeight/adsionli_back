<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['content','author','comment_count','like','see_count'];

    public function comment(){
        return $this->hasMany(Comment::class);
    }
}
