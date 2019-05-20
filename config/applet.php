<?php

return [
    /* applet setting */

    'app_id' => env('APPLET_APP_ID'),

    'app_secret' => env('APPLET_APP_SECRET'),

    'remote_url' =>'https://api.weixin.qq.com',

    'api_token_lifetime' => 60,
    'refresh_token_lifetime' => 360,
];
