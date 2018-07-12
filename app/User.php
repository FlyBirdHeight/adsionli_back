<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','token','is_access','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Hash::make($password);
    }

    public function routeNotificationForMail()
    {
        return $this->email_address;
    }

    public function comment(){
        return $this->hasMany(Comment::class,'user_id');
    }

    public function chatRoom(){
        return $this->belongsToMany(ChatRoom::class,'user_chatroom','user_id','chatRoom_id')->withPivot('nick_name','notify');
    }

    public function hasChatRoom(){
        return $this->hasMany(ChatRoom::class,'user_id');
    }

    public function followers(){
        return $this->belongsToMany(self::class,'followers','follower_id','followed_id')->withTimestamps();
    }
    public function followersUser(){
        return $this->belongsToMany(self::class,'followers','followed_id','follower_id')->withTimestamps();
    }
}
