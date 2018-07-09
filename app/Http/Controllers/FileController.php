<?php

namespace App\Http\Controllers;


use Intervention\Image\Facades\Image;
use App\Repositories\FileRepository;
use App\utils\Responses;
use Illuminate\Http\Request;

class FileController extends Controller
{
    protected $file;
    use Responses;
    public function __construct(FileRepository $fileRepository)
    {
        $this->file = $fileRepository;
    }

    public function uploadImage(Request $request){
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $file_size = $file->getClientSize();
            $file_name = time().$file->getClientOriginalName();
            $file_type = $file->getClientOriginalExtension();
            $user_id = $request->get('userId');
            $url = 'http://127.0.0.1/images/'.$file_name;
            $file->move('images/',$file_name);
            $image = Image::make('images/'.$file_name)->resize(150,150)->save('images/'.$file_name);
            $image = $this->file->addImage(['name'=>$file_name,'url'=>$url,'user_id'=>$user_id,'type'=>$file_type,'size'=>$file_size]);
            return $this->info('success',$image);
        }else{
            return json_encode(['status'=>'error']);
        }
    }

    public function uploadPicture(Request $request){
        if ($request->hasFile('picture')){
            $file = $request->file('picture');
            $file_name = time().$file->getClientOriginalName();
            $url = 'http://127.0.0.1/images/'.$file_name;
            $file->move('images/',$file_name);
            $image = Image::make('images/'.$file_name)->resize(150,150)->save('images/'.$file_name);
            return $this->info('success',$url);
        }else{
            return json_encode(['status'=>'error']);
        }
    }

    public function shortUploadPicture(Request $request){
        if ($request->hasFile('picture')){
            $file = $request->file('picture');
            $file_name = time().$file->getClientOriginalName();
            $url = 'http://101.132.71.227/images/'.$file_name;
            $file->move('images/',$file_name);
            $image = Image::make('images/'.$file_name)->save('images/'.$file_name);
            return $this->info('success',$url);
        }else{
            return json_encode(['status'=>'error']);
        }
    }
}
