<?php
/**
 * Created by PhpStorm.
 * User: adsionli
 * Date: 2018/5/10
 * Time: 21:50
 */

namespace App\utils;


trait Responses
{
    public function info($status,$respond){
        return json_encode(['status' => $status,'response' => $respond]);
    }

    public function succeed($respond = 'Request success!')
    {
        return self::info(true, $respond);
    }

    public function failed($respond = 'Request failed!')
    {
        return self::info(false, $respond);
    }
}