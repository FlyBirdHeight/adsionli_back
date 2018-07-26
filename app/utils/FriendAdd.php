<?php
/**
 * Created by PhpStorm.
 * User: adsionli
 * Date: 2018/7/25
 * Time: 15:22
 */

namespace App\utils;


use Illuminate\Support\Facades\Redis;

trait FriendAdd
{
    /**
     * @param $user_id
     * @param $allow_user_id
     * @return array
     * 获取等待确认添加好友列表
     *
     */
    public function add_list($user_id,$allow_user_id){
        return Redis::smembers("graph:user:{$user_id}:add");
    }

    /**
     * @param $user_id
     * @param int $allow_user_id
     * @return boolean
     * 判断是否是被加好友
     */
    public function is_add($user_id,$allow_user_id=0){
        return Redis::sismember("graph:user:$user_id:allow", $allow_user_id);
    }

    /**
     * @param $user_id
     * @param int $friend_user_id
     * @return boolean
     * 判断是否是好友
     */
    public function is_friend($user_id,$friend_user_id=0){
        return Redis::sismember("graph:user:{$user_id}:friend", $friend_user_id);
    }

    /**
     * @param $user_id
     * @return array
     * 获取全部好友
     */
    public function getAllFriends($user_id){
        return Redis::smembers("graph:user:{$user_id}:friend");
    }

    /**
     * @param $user_id
     * @param $friend_user_id
     * @return string
     * 删除好友
     */
    public function delFriend($user_id,$friend_user_id){
        if ($this->is_friend($user_id,$friend_user_id)){
            Redis::srem("graph:user:{$user_id}:friend",$friend_user_id);
            Redis::srem("graph:user:{$friend_user_id}:friend",$user_id);
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $user_id
     * @param $allow_user_id
     * @return string
     * 被加好友方，同意加好友
     */
    public function allow_friend($user_id,$allow_user_id){
        if (self::is_add($user_id,$allow_user_id)){
            Redis::srem("graph:user:{$user_id}:add",$allow_user_id);
            Redis::srem("graph:user:$allow_user_id:allow",$user_id);
            Redis::sadd("graph:user:{$user_id}:friend",$allow_user_id);
            Redis::sadd("graph:user:{$allow_user_id}:friend",$user_id);
            return "success";
        }else{
            return "error";
        }
    }

    /**
     * @param $user_id
     * @param $allow_user_id
     * @return string
     * 加好友方，不加了
     */
    public function del_allow($user_id,$allow_user_id){
        if (self::is_add($user_id,$allow_user_id)){
            Redis::srem("graph:user:{$user_id}:add",$allow_user_id);
            Redis::srem("graph:user:$allow_user_id:allow",$user_id);
            return "success";
        }else{
            return "error";
        }
    }

    /**
     * @param $user_id
     * @param $allow_user_id
     * @return boolean
     * 被加好友方，不同意加好友
     */
    public function allow_del($user_id,$allow_user_id){
        if (self::is_add($user_id,$allow_user_id)){
            Redis::srem("graph:user:{$user_id}:add",$allow_user_id);
            Redis::srem("graph:user:$allow_user_id:allow",$user_id);
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $user_id
     * @return array
     * 好友请求列表
     */
    public function allow_list($user_id){
        return Redis::smember("graph:user:{$user_id}:allow");
    }
}