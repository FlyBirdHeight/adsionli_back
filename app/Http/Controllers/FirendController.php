<?php

namespace App\Http\Controllers;




use App\utils\FriendAdd;
use App\utils\Responses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class FirendController extends Controller
{
    use FriendAdd;
    use Responses;


    public function addFriend(Request $request){
        $user_id = $request->get('form_user_id');
        $allow_user_id = $request->get('allow_user_id');
        Redis::sadd("graph:user:{$user_id}:add $allow_user_id", $this->user->findUserByid($allow_user_id));
        Redis::sadd("graph:user:$allow_user_id:allow $user_id", $this->user->findUserByid($user_id));
        return $this->info('success','success');
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

    public function get_all_friend($id){
        $friends = $this->getAllFriends($id);
        if (count($friends)>0){
            return $this->info('success',$friends);
        }else{
            return $this->info('empty','empty');
        }
    }

    public function get_all_add($id){
        $add = $this->add_list($id);
        if (count($add)>0){
            return $this->info('success',$add);
        }else{
            return $this->info('empty','empty');
        }
    }

    public function get_all_allow($id){
        $allow = $this->allow_list($id);
        if (count($allow)>0){
            return $this->info('success',$allow);
        }else{
            return $this->info('empty','empty');
        }
    }

    public function del_allow(Request $request){
        $user_id = $request->get('user_id');
        $allow = $request->get('allow_user_id');
        if($this->allowDel($user_id,$allow)){
            return $this->info('success','success');
        }else{
            return $this->info('error','error');
        }
    }

    public function del_add(Request $request){
        $user_id = $request->get('user_id');
        $allow = $request->get('allow_user_id');
        if($this->delAdd($user_id,$allow)){
            return $this->info('success','success');
        }else{
            return $this->info('error','error');
        }
    }

}
