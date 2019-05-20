<?php

namespace App\Http\Controllers\Oauth;

use Illuminate\Http\Request;
use Response;
use App\Models\Token\RefreshToken;
use App\Models\Token\AccessToken;
use App\Http\Controllers\Controller;

class TokenController extends Controller
{
    //
    public function refresh(Request $request) {
        return Response::apiWithTransaction([
            'api_token' => 'required',
            'open_id' => 'required',
            'refresh_token' => 'required',
        ], [
            'refresh_token' => function($v, $d) {
                $refresh_token = RefreshToken::find($v);
                if(!$refresh_token) {
                    return 'refresh_token is not valid';
                }
                if($refresh_token->isExpired()) {
                    return 'refresh_token is expired';
                }
                $access_token = $refresh_token->access_token;
                if($access_token->api_token != $d['api_token']) {
                    return 'access_token is not valid';
                }
                $user = $access_token->user;
                $open_id = $user->open_id;
                if($open_id != $d['open_id']) {
                    return 'open_id is not valid';
                }
            },
        ], function($d) {
            /*
            $input = $request->all();
            $refresh_token = $input['refresh_token'] ?? '';
            $api_token = $input['api_token'] ?? '';
            $open_id = $input['open_id'] ?? '';
            if(empty($refresh_token) || empty($api_token) || empty($open_id)) {
                return $this->error('refresh_token, api_token, open_id is all required');
            $refresh_token = RefreshToken::find($refresh_token);
            if(!$refresh_token) {
                return $this->error('refresh_token is not valid');
            } 
            if($refresh_token->isExpired() || !$refresh_token->needRefresh()) {
                return $this->error('refresh_token is not valid');
            }
             */
            $refresh_token = RefreshToken::find($d['refresh_token']);
            $access_token = $refresh_token->access_token;
            $user = $access_token->user;
            if(!$refresh_token->needRefresh()) {
                $access_token->delayExpiredTime(config('applet.api_token_lifetime'));
                $refresh_token = $access_token->createNewRefreshToken();
            } else {
                $access_token->delete();
                $tokens = AccessToken::CreateWithRefresh($user->id);
                if(empty($tokens['access_token']) || empty($tokens['refresh_token'])) {
                    return $this->error('token 创建失败');
                }
                $access_token = $tokens['access_token'];
                $refresh_token = $tokens['refresh_token'];
            }
            return $this->success([
                'open_id' => $user->open_id,
                'api_token' => $access_token->api_token,
                'expired_in' => $access_token->getExpiredTime(),
                'refresh_token' => $refresh_token->refresh_token
            ]);
        });
    }
}
