<?php

namespace App\Http\Controllers;

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
}
