<?php

namespace App\Http\Controllers;

use App\Repositories\ChatRepository;
use App\Repositories\UserRepository;
use App\utils\Responses;
use GatewayClient\Gateway;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $chat;
    protected $user;
    use Responses;

    public function __construct(ChatRepository $repository,UserRepository $userRepository)
    {
        Gateway::$registerAddress = '101.132.71.227:2364';
        $this->chat = $repository;
        $this->user = $userRepository;
    }

    public function sendMessage(Request $request){
        $client_id = $request->get('client_id');
    }

    public function addChatRoom(Request $request){
        $data = [
            'user_id' => $request->get('user_id'),
            'name' => $request->get('name'),
            'max_user_count' => $request->get('max_user_count'),
            'agree' => $request->get('agree'),
            'user_count' => 1
        ];
        $room = $this->chat->add($data);
        $room->userJoinRoom($room['user_id']);
        return $this->info('success',$room);
    }

    public function joinRoom(Request $request){
        $room = $this->chat->find($request->get('room_id'));
        if ($room->max_user_count > $room->user_count){
            $room->increment('user_count');
            return $this->succeed('join success');
        }else{
            return $this->failed('full of people');
        }

    }

    public function delRoom($id){
        $room = $this->chat->find($id);
        return $room->del();
    }

    public function editRoom(Request $request){
        $status = $this->chat
            ->edit(['room_id'=>$request->get('room_id'),'name'=>$request->get('name'),'max_user_count'=>$request->get('max_user_count')]);
        if ($status){
            return $this->succeed('edit success');
        }else{
            return $this->failed('edit failed');
        }
    }

    public function chatRoom($id)
    {
        $user = $this->user->findUserByid($id);
        if (count($user->chatRoom)!=0){
            return $this->info('success',$user->chatRoom);
        }else{
            return $this->info('error','empty');
        }

    }
}
