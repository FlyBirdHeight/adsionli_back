<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
