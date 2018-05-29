<?php
/**
 * Created by PhpStorm.
 * User: adsionli
 * Date: 2018/5/25
 * Time: 10:27
 */
return [
    'proxy' => [
        'grant_type'    => env('OAUTH_GRANT_TYPE'),
        'client_id'     => env('OAUTH_CLIENT_ID'),
        'client_secret' => env('OAUTH_CLIENT_SECRET'),
        'scope'         => env('OAUTH_SCOPE', '*'),
    ],
];