<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message1 extends Model
{
    protected $fillable = ['user_id','userAvatar','title','contentDate','content'];
}
