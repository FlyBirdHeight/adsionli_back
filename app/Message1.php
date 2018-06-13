<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message1 extends Model
{
    protected $fillable = ['userId','userAvatar','title','contentDate','content','special_id'];
}
