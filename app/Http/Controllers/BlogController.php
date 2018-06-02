<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository;
use App\utils\Responses;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $comment;
    use Responses;
    public function __construct(CommentRepository $commentRepository){
        $this->comment = $commentRepository;
    }

    public function blog($id){

    }

    public function addBlog(Request $request){

    }

    public function delBlog($id){

    }

    public function editBlog(Request $request){

    }

    public function likeBlog(){

    }

    public function comment($id){
        $comments = $this->comment->comment($id);
        if (count($comments)!=0){
            return $this->info('success',$comments);
        }else{
            return $this->info('empty',$comments);
        }
    }

    public function addComment(Request $request){
        $data = [
            'bolg_id' => $request->get('blog_id'),
            'user_id' => $request->get('user_id'),
            'body' => $request->get('body'),
        ];
        $status = $this->comment->addComment($data);
        if ($status == 'success'){
            return $this->info($status,'success');
        }else{
            return $this->info($status,'error');
        }
    }
}

