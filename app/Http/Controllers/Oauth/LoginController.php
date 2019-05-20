<?php

namespace App\Http\Controllers\Oauth;

use Illuminate\Http\Request;
use App\Services\NetConnection\AppletHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\User;
use App\Models\Token\AccessToken;
use Response;

class LoginController extends Controller
{
    //
    public function login(Request $request, AppletHelper $helper) {
        return Response::apiWithTransaction([
            'code' => 'required'
        ],[], function($d) use($helper) {
                /*
            $input = $request->all();
            $code = $input['code'] ?? '';
            if(empty($code)) {
                return $this->error('code is required');
            }
                 */
            $result = $helper->code2Session($d['code']);
            if(!$result['success']) {
                Log::error("code " . $code . ",action code2Session, error msg " . $result['msg']);
                return $this->error($data['errmsg']);
            } else {
                $data = $result['data'];
                Cache::put($d['code'], implode('|', $data), 10);
                $user = User::where('open_id', $data['openid'])->first();
                if(!$user) {
                    $user = new User;
                    $user->open_id = $data['openid'];
                }
                $user->union_id = $data['unionid'] ?? '';
                $user->session_key = $data['session_key'];
                $user->save();
                if($token = $user->access_token) {
                    $token->delete();
                }
                $tokens = AccessToken::CreateWithRefresh($user->id);
                if(empty($tokens['access_token']) || empty($tokens['refresh_token'])) {
                    return $this->error('token 创建失败');
                }
                return $this->success([
                    'open_id' => $user->open_id,
                    'api_token' => $tokens['access_token']->api_token,
                    'expired_in' => $tokens['access_token']->getExpiredTime(),
                    'refresh_token' => $tokens['refresh_token']->refresh_token,
                ]);

            }
        });
    }
}
