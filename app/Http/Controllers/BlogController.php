<?php

namespace App\Http\Controllers;

use App\Repositories\BlogRepository;
use App\Repositories\CommentRepository;
use App\utils\Responses;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $comment;
    protected $blog;
    use Responses;
    public function __construct(CommentRepository $commentRepository,BlogRepository $blogRepository){
        $this->comment = $commentRepository;
        $this->blog = $blogRepository;
    }

    /**
     * @param Request $request
     * @return json
     * 获取全部博文
     * post
     */
    public function all(Request $request){
        $blog = $this->blog->all($request->get('page'));
        \Log::info('see all blog');
        if (count($blog)!=0){
            return $this->info('success',$blog);
        }else{
            \Log::error('blog empty');
            return $this->info('error','empty');
        }
    }

    /**
     * @param $id
     * @return json
     * get
     * 获取单个博文及评论及标签
     */
    public function blog($id){
        $blog = $this->blog->blog($id);
        \Log::info('see blog '.$id,['blog_id'=>$id]);
        $blog->increment('see_count');
        return $this->info('success',$blog);
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

