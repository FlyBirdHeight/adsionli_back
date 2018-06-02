<?php
/**
 * Created by PhpStorm.
 * User: adsionli
 * Date: 2018/6/1
 * Time: 21:20
 */

namespace App\Repositories;


use App\Comment;

class CommentRepository
{
    public function comment($id){
        $comment = Comment::where('blog_id',$id)->orderBy('created_at','desc')->with('user')->get();
        return $comment;
    }

    public function addComment(array $arr){
        $comment = Comment::create($arr);
        return $comment;
    }
}