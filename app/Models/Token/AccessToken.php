<?php

namespace App\Models\Token;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends BaseToken
{
    //
    //
    protected $table = 'user_access_token';
    protected $primaryKey = 'api_token';

    public function user() {
        return $this->belongsTo('\App\User');
    }

    public function refresh_token() {
        return $this->hasOne('\App\Models\Token\RefreshToken', 'token_id', 'api_token');
    }

    public function delete() {
        if($refreshtoken = $this->refresh_token) {
            $refreshtoken->delete();
        }
        parent::delete();
    }

    public function delayExpiredTime($minutes = null) {
        $minutes = $minutes === null ? config('applet.api_token_lifetime') : $minutes;
        $this->expired_in = $this->expired_in->addMinutes($minutes);
        $this->save();
    }

    public function createNewRefreshToken() {
        if($refresh_token = $this->refresh_token) {
            $refresh_token->delete();
        }
        $refresh = new RefreshToken;
        $refresh->refresh_token = static::tokenGenerate();
        $refresh->token_id = $this->api_token;
        $refresh->expired_in = now()->addMinutes(config('applet.refresh_token_lifetime'));
        $refresh->save();
        return $refresh;
    }

    public static function createWithRefresh($user_id) {
        $res = [];
        $token = new static;
        $token->api_token = static::tokenGenerate();
        $token->user_id = $user_id;
        $token->expired_in = now()->addMinutes(config('applet.api_token_lifetime'));
        if($token->save()) {
            $res['access_token'] = $token;
            $refresh = new RefreshToken;
            $refresh->refresh_token = static::tokenGenerate();
            $refresh->token_id = $token->api_token;
            $refresh->expired_in = now()->addMinutes(config('applet.refresh_token_lifetime'));
            if($refresh->save()) {
                $res['refresh_token'] = $refresh;
            }

        }
        return $res;
    }

}
