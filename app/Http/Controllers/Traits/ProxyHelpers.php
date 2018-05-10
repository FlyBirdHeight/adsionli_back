<?php
/**
 * Created by PhpStorm.
 * User: adsionli
 * Date: 2018/5/9
 * Time: 16:54
 */

namespace App\Http\Controllers\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Validation\UnauthorizedException;
trait ProxyHelpers
{
    public function authenticate()
    {
        $client = new Client();
        try {
            $url = request()->root() . '/api/oauth/token';
            $params = array_merge(config('passport.proxy'), [
                'username' => request('email'),
                'password' => request('password'),
            ]);
            $respond = $client->request('POST', $url, ['form_params' => $params]);
        } catch (RequestException $exception) {
            throw  new UnauthorizedException('请求失败，服务器错误');
        }
        if ($respond->getStatusCode() !== 401) {
            return json_decode($respond->getBody()->getContents(), true);
        }

        throw new UnauthorizedException('账号或密码错误');
    }
}