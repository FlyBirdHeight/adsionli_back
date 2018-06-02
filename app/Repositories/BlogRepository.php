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
        $blog->tag;
        $blog->comment;
        return $blog;
    }

    public function all($page){
        if($page == 1){
            $blog = Blog::orderBy('created_at','desc')->skip(0)->limit(10)->get();
        }else{
            $blog =  Blog::orderBy('created_at','desc')->skip(($page-1)*10)->limit(10)->get();
        }
        return $blog;
    }
}