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

    public function all($page,$count){
        if($page == 1){
            $blogs = Blog::orderBy('created_at','desc')->skip(0)->limit($count)->get();
            foreach ($blogs as $blog){
                $blog->tag;
            }
        }else{
            $blogs =  Blog::orderBy('created_at','desc')->skip(($page-1)*$count)->limit($count)->get();
            foreach ($blogs as $blog){
                $blog->tag;
            }
        }
        return $blogs;
    }

    public function blogCount(){
        return count(Blog::all());
    }
}