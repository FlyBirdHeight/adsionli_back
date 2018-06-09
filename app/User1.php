<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User1 extends Model
{
    protected $fillable = ['user_name','user_passwork','wechat_name','wechat_openid','qq_name','qq_openid','weibo_name','weibo_openid','image','phone','height','weight','sex','birthday','alterDate','m_major','m_class'];
}
