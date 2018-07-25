<?php

namespace App\Http\Controllers;



use App\utils\FriendAdd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class FirendController extends Controller
{
    use FriendAdd;

    public function addFriend(Request $request){
        $user_id = $request->get('form_user_id');
        $allow_user_id = $request->get('allow_user_id');
        Redis::sadd("graph:user:{$user_id}:add", $allow_user_id);
        Redis::sadd("graph:user:$allow_user_id:allow", $user_id);
    }

    public function selectFriend(Request $request){

    }

    public function delFriend(Request $request){

    }

    public function agreeFriend(Request $request){
        if ($this->is_add($request->get('user_id'),$request->get('allow_id'))){

        }
    }
}
