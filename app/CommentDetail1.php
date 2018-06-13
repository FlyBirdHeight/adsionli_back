<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentDetail1 extends Model
{
    protected $fillable = ['nickName','userLogo','content','imgId','replyTotal','special_id'];
}
