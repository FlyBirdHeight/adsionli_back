<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MusicList extends Model
{
    protected $fillable = ['name','path','artist','cover','theme','lrc'];

}
