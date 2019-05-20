<?php

namespace App\Services\NetConnection;

class AppletHelper {

    protected $http;

    public function __construct(HttpInterface $http) {
        $this->http = $http;
    }

    public function code2Session($code) {
        //test use
            return [
                'success' => true,
                'data' =>[
                    'openid' => sha1('a12r32fdfsadf'),
                    'unionid' => sha1('bfdsgargarga'),
                    'session_key' => sha1('dadfsdfsdfdf'),
                    'errorCode' => 0,
                ]
            ];

        $http = $this->http;
        $http->setPath('/sns/jscode2session');
        $response = $http->get([
            'appid' => config('applet.app_id'),
            'secret' => config('applet.app_secret'),
            'js_code' => $code,
            'grant_type' => 'authorization_code',

        ]);
        if(!empty($response['errcode'])) {
            return [
                'success' => false,
                'msg' => $response['errmsg'] ?? 'session请求失败',
                ];
        }
        unset($response['errcode']);
        unset($response['errmsg']);
        return [
            'success' => true,
            'data' => $response
        ];
    }
}
