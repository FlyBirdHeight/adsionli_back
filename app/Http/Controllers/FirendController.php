<?php

namespace App\Http\Controllers;



use App\Repositories\UserRepository;
use App\utils\FriendAdd;
use App\utils\Responses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class FirendController extends Controller
{
    use FriendAdd;
    use Responses;
    protected $user;

    public function __construct(UserRepository $userRepository)
    {
        $this->user = $userRepository;
    }

    public function addFriend(Request $request){
        $user_id = $request->get('form_user_id');
        $allow_user_id = $request->get('allow_user_id');
        Redis::sadd("graph:user:{$user_id}:add", $allow_user_id);
        Redis::sadd("graph:user:$allow_user_id:allow", $user_id);
    }

    public function selectFriend(Request $request){

    }

    public function del_friend(Request $request){
        if ($this->delFriend($request->get('user_id'),$request->get('friend_user_id'))){
            return $this->info('success','success');
        }else{
            return $this->info('error','error');
        }
    }

    public function agreeFriend(Request $request){
        if ($this->is_add($request->get('user_id'),$request->get('allow_id'))){
            return $this->info('success','success');
        }else{
            return $this->info('error','error');
        }
    }

    public function delAllow(Request $request){
        $status = $this->del_allow($request->get('user_id'),$request->get('allow_user_id'));
        if ($status){
            return $this->info('success','success');
        }else{
            return $this->info('error','error');
        }
    }

    public function get_all_friend($id){
        $friends = $this->getAllFriends($id);
        $data = [];
        for($i=0;$i<count($friends);$i++){
            array_push($data,$this->user->findUserByid($friends[$i]));
        }
    }
}
