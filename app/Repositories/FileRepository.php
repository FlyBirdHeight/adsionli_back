<?php
/**
 * Created by PhpStorm.
 * User: adsionli
 * Date: 2018/5/30
 * Time: 23:50
 */

namespace App\Repositories;


use App\Image;

class FileRepository
{
    public function addImage(array $array){
        $image = Image::create($array);
        if (count($image)!=0){
            return $image;
        }else{
            return $image;
        }
    }
}