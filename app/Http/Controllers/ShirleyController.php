<?php

namespace App\Http\Controllers;

use App\CommentDetail1;
use App\Love1;
use App\MenuPo1;
use App\Message1;
use App\ReplyDetail1;
use App\Special1;
use App\TalentShow1;
use App\User;
use App\User1;
use Carbon\Carbon;
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
            return json_encode(['code'=>1000,'message'=>'查看评论成功','data'=>['total'=>count($comments),'list'=>$comments]]);
        }else{
            return 'empty';
        }
    }

    public function addComment(Request $request){
        $user = User1::where('id',$request->get('user_id'))->first();
        $special = Special1::where('title',$request->get('special_title'))->first();
        $special->increment('commentNum');
        $special->save();
        $data = [
            'special_id'=>$special->id,
            'nickName' => $user->user_name,
            'userLogo' => $user->image,
            'content' => $request->get('content'),
            'imgId' => 'xcclsscrt0tev11ok364',
        ];
        $comment = CommentDetail1::create($data);
        Message1::create([
            'userId'=>$special->user_id,
            'userAvatar'=>User1::where('id',$special->user_id)->first()->image,
            'title'=>'系统消息',
            'contentDate'=>Carbon::now()->format("Y-m-d H:i:s"),
            'content'=>"您的日记被人评论啦，快去回复吧",
            "special_id"=>$special->id
        ]);
        return $comment;
    }

    public function addReply(Request $request){
        $user = User1::where('id',$request->get('user_id'))->first();
        $comment = CommentDetail1::where('id',$request->get('commentId'))->first();
        $user1 = User1::where('user_name',$comment->nickName)->first();
        $comment->increment('replyTotal');
        $comment->save();
        Message1::create([
            'userId'=>$user1->id,
            'userAvatar'=>$user->image,
            'title'=>'系统消息',
            'contentDate'=>Carbon::now()->format("Y-m-d H:i:s"),
            'content'=>"您的评论被人回复啦，快去看看吧",
            'special_id'=>Special1::where('id',$comment->special_id)->first()->id
        ]);
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

    public function getSpecialByTitle(Request $request){
        $name = $request->get('title');
        $special = Special1::where('title',$name)->first();
        $special['user'] = User1::where('id',$special->user_id)->first();
        return $special;
    }

    public function isLove(Request $request){
        $special = Special1::where('title',$request->get('special_title'))->first();
        $love = Love1::where(['userId'=>$request->get('userId'),'specialId'=>$special->id])->get();
        if (count($love)!=0){
            return 'success';
        }else{
            return 'error';
        }
    }

    public function addLove(Request $request){
        $special = Special1::where('title',$request->get('special_title'))->first();
        $love = Love1::where(['userId'=>$request->get('userId'),'specialId'=>$special->id])->first();
        if (count($love)!=0){
            $love->delete();
            $special->decrement('likeNum');
            $special->save();
            return 'del success';
        }else{
            $love = Love1::create(['userId'=>$request->get('userId'),'specialId'=>$special->id]);
            $special->increment('likeNum');
            $special->save();
            return 'add success';
        }
    }

    public function getSpecialById(Request $request){
        $special = Special1::findOrFail($request->get('id'));
        $special['user'] = User1::where('id',$special->user_id)->first();
        return $special;
    }

    public function getAllSpecial(){
        $specials = \DB::table('special1s')->select('*')->orderBy('created_at','desc')->get();
        return $specials;
    }
}
