<?php

namespace App\Http\Controllers;

use App\MenuPo1;
use App\Message1;
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
        $data = [
            'title'=>$request->get('title'),
            'content' => $request->get('content'),
            'commentNum' => 0,
            'likeNum'=>0,
            'user_id'=>$request->get('user_id'),
            'imgId' => $request->get('imgId')
        ];
        $special = Special1::create($data);
        $menupols = count(MenuPo1::all());
        if ($menupols<6){
            MenuPo1::create(['commentNum'=>"0",'dishName'=>$special['title'],'dishIntro'=>$special['content'],'likeNum'=>"0"]);
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
}
