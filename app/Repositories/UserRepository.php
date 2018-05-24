<?php
/**
 * Created by PhpStorm.
 * User: adsionli
 * Date: 2018/5/23
 * Time: 18:25
 */

namespace App\Repositories;


use App\User;

class UserRepository
{
    public function register(array $arr){
        $user = User::create($arr);
        return $user;
    }

    public function findUser($email){
        $user = User::where('email',$email)->get();
        if(count($user) != 0){
            return $user;
        }else{
            return "none";
        }
    }

    public function findByToken($token){
        $user = User::where('token',$token)->first();
        return $user;
    }
}