<?php
/**
 * Created by PhpStorm.
 * User: adsionli
 * Date: 2018/5/10
 * Time: 21:36
 */

namespace App\Repositories;


use App\MusicList;

class MusicRepositories
{
    public function getMusicList(){
        $music = MusicList::all();
        if (count($music)==0){
            return 'empty';
        }else{
            return $music;
        }
    }

    public function addMusicList(array $arr){
        if ($data = MusicList::create($arr)){
            return $data;
        }else{
            return 'error';
        }
    }

    public function getMusicById($id){
        $music = MusicList::findOrFail($id);
        return $music;
    }

    public function delMusic($id){
        $music = $this->getMusicById($id);
        $music->delete();
        return 'success';
    }
}