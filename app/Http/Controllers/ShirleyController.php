<?php

namespace App\Http\Controllers;

use App\CommentDetail1;
use App\MenuPo1;
use App\Message1;
use App\ReplyDetail1;
use App\Special1;
use App\TalentShow1;
use App\User;
use App\User1;
use Illuminate\Http\Request;

class ShirleyController extends Controller
{
    public function login(Request $request){
        $user = User1::where('user_name',$request->get('user_name'))->first();
        if($user['user_passwork'] == $request->get('user_passwork')){
            return json_decode($user, true);
        }
        return 'error';
    }

    public function register(Request $request){
        $data = [
            'user_name'=>$request->get('user_name'),
            'user_passwork' => $request->get('user_passwork'),
            'phone' => $request->get('phone'),
            'image' => 'http://onasmniwj.bkt.clouddn.com/avatars/f94a76806a6c142145300d55543adcbc.jpg',
            'height'=> '',
            'weight'=> '',
            'sex'=> '',
            'birthday'=> '',
            'alterDate'=> '',
            'm_major'=> '',
            'm_class'=> '',
        ];
        $user = User1::create($data);
        $talents = count(TalentShow1::all());
        if ($talents<5){
            $talent = TalentShow1::create(['avatarId'=>$user['image'],'nickName'=>$user['user_name']]);
        }
        return 'success';
    }

    public function editUser(Request $request){
        $user = User1::findOrFail($request->get('id'));
        $user->sex = $request->get('sex');
        $user->birthday = $request->get('birthday');
        $user->m_major = $request->get('m_major');
        $user->m_class = $request->get('m_class');
        $user->save();
        return 'success';
    }

    public function editUserPassword(Request $request){
        $user = User1::findOrFail($request->get('id'));
        if ($user['user_passwork'] == $request->get('oldPasswork')){
            $user->user_passwork = $request->get('passwork');
            $user->save();
            return 'success';
        }else{
            return 'error';
        }
    }

    public function uploadImg(Request $request){
        $user = User1::findOrFail($request->get('id'));
        $user->image = $request->get('image');
        $user->save();
        return 'success';
    }

    public function user($id){
        return User1::findOrFail($id);
    }

    public function special(){
        $special = Special1::orderBy('likeNum','desc')->skip(0)->limit(5)->get();
        if (count($special)!=0){
            return $special;
        }else{
            return 'empty';
        }
    }

    public function addSpecial(Request $request){
        $img = $request->get('imgId');
        if ($img == ""){
            $img = "http://bmob-cdn-14824.b0.upaiyun.com/2018/06/10/e672d16f0ddf42e5a49ba8318415921e.jpg";
        }
        $data = [
            'title'=>$request->get('title'),
            'content' => $request->get('content'),
            'commentNum' => 0,
            'likeNum'=>0,
            'user_id'=>$request->get('user_id'),
            'imgId' => $img
        ];
        $special = Special1::create($data);
        $menupols = count(MenuPo1::all());
        if ($menupols<6){
            MenuPo1::create(['imgId'=>$special['imgId'],'commentNum'=>"0",'dishName'=>$special['title'],'dishIntro'=>$special['content'],'likeNum'=>"0"]);
        }
        return 'success';
    }

    public function getSpecialByCommentNum(){
        $special = MenuPo1::orderBy('commentNum','desc')->skip(0)->limit(6)->get();
        if (count($special)!=0){
            return $special;
        }else{
            return 'empty';
        }
    }

    public function getSpecialUser(){
        $user = TalentShow1::skip(0)->limit(5)->get();
        if (count($user)!=0){
            return $user;
        }else{
            return 'empty';
        }
    }

    public function getMessage($id){
        $message = Message1::where('userId',$id)->orderBy('created_at','desc')->get();
        if (count($message)!=0){
            return $message;
        }else{
            return 'empty';
        }
    }

    public function getComment(Request $request){
        $name = $request->get('special_title');
        $special = Special1::where('title',$name)->first();
        $special_id = $special->id;
        $comments = CommentDetail1::where('special_id',$special_id)->orderBy('created_at','desc')->get();
        if (count($comments)!=0){
            foreach ($comments as $comment){
                $reply = ReplyDetail1::where('commentId',$comment['id'])->orderBy('created_at','desc')->get();
                if (count($reply)!=0){
                    $comment['replyList'] = $reply;
                }else{
                    $comment['replyList'] = null;
                }
            }
            return $comments;
        }else{
            return 'empty';
        }
    }

    public function addComment(Request $request){
        $user = User1::where('id',$request->get('user_id'))->first();
        $data = [
            'special_id'=>Special1::where('title',$request->get('special_title'))->first()->id,
            'nickName' => $user->user_name,
            'userLogo' => $user->image,
            'content' => $request->get('content'),
            'imgId' => 'xcclsscrt0tev11ok364',
        ];
        $comment = CommentDetail1::create($data);
        return $comment;
    }

    public function addReply(Request $request){
        $user = User1::where('id',$request->get('user_id'))->first();
        $data = [
            'nickName' => $user->user_name,
            'userLogo' => $user->image,
            'commentId'=>$request->get('commentId'),
            'content' => $request->get('content'),
            'status' => '01'
        ];
        $reply = ReplyDetail1::create($data);
        return $reply;
    }
}
