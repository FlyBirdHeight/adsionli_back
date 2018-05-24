<?php

namespace App\Http\Controllers;

use App\Mail\RegisterMail;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    use Traits\ProxyHelpers;
    private $user;
    public function __construct(UserRepository $userRepository)
    {
        $this->user = $userRepository;
    }

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
//        return $this->user->findUser($request->get('email'));
        if($this->user->findUser($request->get('email')) == "none"){
            $name = $request->get('name');
            $email = $request->get('email');
            $password = $request->get('password');
            $token = str_random(32);
            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'token' => $token
            ];
            $user = $this->user->register($data);
            Redis::set($token,json_encode(['name'=>$name,'email'=>$email,'password'=>$password,'token'=>$token]));
            Redis::expire($token,3600);
            $url = 'http://127.0.0.1:8080/#/success/'.$token;
            Mail::to($email)->queue(new RegisterMail($url,$name));
            return json_encode(['status'=>'success','content'=>$token]);
        }else{
            $user = $this->user->findUser($request->get('email'));
            $token = $user[0]->token;
            if(Redis::exists($token)){
                return json_encode(['status'=>'error','content'=>'你已经完成了注册，请前往邮箱验证，可能存在于邮箱垃圾箱中']);
            }else{
                if ($user->is_access=="true"){
                    return json_encode(['status'=>'true','content'=>'你已经完成了注册且认证过，请勿重新注册']);
                }else{
                    $user->delete();
                    return json_encode(['status'=>'overtime','content'=>'你超过一小时未进行邮箱验证，请重新注册']);
                }
            }
        }
    }

    public function userTokenEdit(Request $request){
        $token = $request->get('token');
        $user = $this->user->findByToken($token);
        if ($user->is_access=="false"){
            if (Redis::exists($token)){
                $user->token = str_random(32);
                $user->is_access = "true";
                $user->save();
                return json_encode(['status'=>'success']);
            }else{
                return json_encode(['status'=>'overtime']);
            }
        }else{
            return json_encode(['status'=>'isAccess']);
        }
    }
}
