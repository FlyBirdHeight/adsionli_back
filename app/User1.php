<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User1 extends Model
{
    protected $fillable = ['user_name','user_passwork','image','phone','height','weight','sex','birthday','alterDate','m_major','m_class','special_count'];
}
