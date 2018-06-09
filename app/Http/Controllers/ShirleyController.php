<?php

namespace App\Http\Controllers;

use App\User1;
use Illuminate\Http\Request;

class ShirleyController extends Controller
{
    public function login(Request $request){
        $user = User1::where('user_name',$request->get('user_name'))->first();
        if($user['user_password'] == $request->get('user_password')){
            return json_encode(['status' => "success",'user'=>$user]);
        }
        return json_encode(['status' => 'error','content'=>'错误']);
    }

    public function register(Request $request){
        $data = [
            'user_name'=>$request->get('user_name'),
            'user_password' => $request->get('user_password'),
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
        return json_encode(['status'=>'success','user'=>$user]);
    }
}
