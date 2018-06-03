<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $fillable = ['name','user_count'];

    public function user(){
        return $this->belongsToMany(User::class,'user_chatRoom','chatRoom_id','user_id ')->withTimestamps();
    }
}
