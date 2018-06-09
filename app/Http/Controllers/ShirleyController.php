<?php

namespace App\Http\Controllers;

use App\User;
use App\User1;
use Illuminate\Http\Request;

class ShirleyController extends Controller
{
    public function login(Request $request){
        $user = User1::where('user_name',$request->get('user_name'))->first();
        if($user['user_password'] == $request->get('user_password')){
            return $user;
        }
        return 'error';
    }

    public function register(Request $request){
        $data = [
            'user_name'=>$request->get('user_name'),
            'user_password' => $request->get('user_password'),
            'phone' => $request->get('phone'),
            'image' => 'http://onasmniwj.bkt.clouddn.com/avatars/f94a76806a6c142145300d55543adcbc.jpg',
            'height'=> '',
            'weight'=> '',
            'sex'=> '',
            'birthday'=> '',
            'alterDate'=> '',
            'm_major'=> '',
            'm_class'=> '',
        ];
        $user = User1::create($data);
        return json_encode(['status'=>'success','user'=>$user]);
    }

    public function editUser(Request $request){
        $user = User1::findOrFail($request->get('userId'));
        $user->sex = $request->get('sex');
        $user->birthday = $request->get('birthday');
        $user->m_major = $request->get('m_major');
        $user->m_class = $request->get('m_class');
        $user->save();
        return 'success';
    }

    public function editUserPassword(Request $request){
        $user = User1::findOrFail($request->get('userId'));
        if ($user['password'] == $request->get('oldPassword')){
            $user->password = $request->get('password');
            $user->save();
            return 'success';
        }else{
            return 'error';
        }
    }

    public function uploadImg(Request $request){
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $file_size = $file->getClientSize();
            $file_name = time().$file->getClientOriginalName();
            $file_type = $file->getClientOriginalExtension();
            $user_id = $request->get('userId');
            $url = 'http://101.132.71.227/images/'.$file_name;
            $file->move('images/',$file_name);
            $image = Image::make('images/'.$file_name)->resize(150,150)->save('images/'.$file_name);
            $image = $this->file->addImage(['name'=>$file_name,'url'=>$url,'user_id'=>$user_id,'type'=>$file_type,'size'=>$file_size]);
            $user = User1::findOrFail($request->get('userId'));
            $user->image = $url;
            $user->save();
            return 'success';
        }else{
            return 'error';
        }
    }
}
