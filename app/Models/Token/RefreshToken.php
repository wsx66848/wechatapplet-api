<?php

namespace App\Models\Token;

use Illuminate\Database\Eloquent\Model;

class RefreshToken extends BaseToken
{
    //
    protected $table = 'user_refresh_token';
    protected $primaryKey = 'refresh_token';

    public function access_token() {
        return $this->belongsTo('\App\Models\Token\AccessToken', 'token_id', 'api_token');
    }

    public function needRefresh() {
        return $this->access_token->isExpired();
    }
}
