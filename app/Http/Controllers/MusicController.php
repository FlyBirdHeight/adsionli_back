<?php

namespace App\Http\Controllers;

use App\Repositories\MusicRepositories;
use App\utils\Responses;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    use Responses;
    protected $music;
    public function __construct(MusicRepositories $musicRepositories)
    {
        $this->music = $musicRepositories;
    }

    public function getMusicList(){
        $musics = $this->music->getMusicList();
        if ($musics!='empty'){
            return $this->info('success',$musics);
        }else{
            return $this->info('empty','empty');
        }
    }

    public function uploadMusic(Request $request){
        if ($request->hasFile('music')){
            $file = $request->file('music');
            $destinationPath = 'music/';
            $filename = time().$file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            return $this->info('success',$destinationPath.$filename);
        }else{
            return $this->failed('no file');
        }
    }

    public function addMusic(Request $request){
        $data = [
            'name'=> $request->get('name'),
            'path'=> $request->get('path'),
            'artist'=>$request->get('artist'),
            'cover'=>$request->get('cover')
        ];
        $music = $this->music->addMusicList($data);
        if ($music!='error'){
            return $this->info('success',$music);
        }else{
            return $this->info('error','add failed');
        }
    }

    public function delMusic(Request $request){
        $music = $this->music->delMusic($request->get('id'));
        return $this->info('success',$music);
    }
}
