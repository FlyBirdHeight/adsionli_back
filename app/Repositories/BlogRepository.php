<?php
/**
 * Created by PhpStorm.
 * User: adsionli
 * Date: 2018/6/1
 * Time: 22:04
 */

namespace App\Repositories;


use App\Blog;

class BlogRepository
{
    public function blog($id){
        $blog = Blog::findOrFail($id);
        return $blog;
    }
}