<?php
/**
 * Created by PhpStorm.
 * User: adsionli
 * Date: 2018/6/7
 * Time: 11:35
 */

namespace App\Repositories;


use App\ChatRoom;

class ChatRepository
{
    public function add(array $arr){
        return ChatRoom::create($arr);
    }

    public function find($id){
        return ChatRoom::findOrFail($id);
    }

    public function edit($data){
        $room = $this->find($data['room_id']);
        $room->name = $data['name'];
        $room->max_user_count = $data['max_user_count'];
        $room->save();
        return true;
    }
}