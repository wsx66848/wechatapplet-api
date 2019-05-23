<?php

return [
    /* applet setting */

    'app_id' => env('APPLET_APP_ID'),

    'app_secret' => env('APPLET_APP_SECRET'),

    'remote_url' =>'https://api.weixin.qq.com',

    'api_token_lifetime' => 60,
    'refresh_token_lifetime' => 360,
    'errorcode' => [
        '51' => 'api_token expired',
        '52' => 'api_token is not valid',
        '53' => 'refresh_token expired',
        '54' => 'refresh_token is not valid',
        '55' => 'open_id is not valid',
    ],
];
