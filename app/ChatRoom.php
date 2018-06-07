<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $fillable = ['name','user_count','max_user_count','user_id','agree'];

    public function user(){
        return $this->belongsToMany(User::class,'user_chatroom','chatRoom_id','user_id');
    }

    public function userJoinRoom($user_id){
        return $this->user()->toggle($user_id);
    }

    public function isUserJoinRoom($user_id)
    {
        return !!$this->user()->where('user_id', $user_id)->count();
    }
}
