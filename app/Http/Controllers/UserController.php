<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    use Traits\ProxyHelpers;

    public function login(Request $request){
        $field = filter_var($request->get('email'),FILTER_VALIDATE_EMAIL)?'email':'phone';
        $request->merge([$field=>$request->get('email')]);
        if(\Auth::attempt($request->only($field,'password'))){
            $user = \Auth::user();
            $tokens = $this->authenticate();
            if($user->isAdmin()){
                return json_encode(['status' => "success", 'token' => $tokens,'userInfo'=>$user]);
            }else{
                $user = $this->user->getUserById($user->id);
            }
            return json_encode(['status' => "success", 'token' => $tokens,'userInfo'=>$user]);
        }
        return json_encode(['status' => 'error']);
    }

    public function register(Request $request){
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $token = str_random(32);
        Redis::set($token,json_encode(['name'=>$name,'email'=>$email,'password'=>$password,'token'=>$token]));
        Redis::expire($token,21600);
        return Redis::get($token);
    }
}
