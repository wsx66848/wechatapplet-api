<?php

namespace App\Models\Token;

use Illuminate\Database\Eloquent\Model;

class BaseToken extends Model
{
    //
    public $incrementing = false;
    protected $keyType = 'string';
    protected $dateFormat = 'Y-m-d H:i:s';
    public $timestamps = false;
    protected $dates = [
        'expired_in',
    ];

    const APITOKEN_EXPIRED = 51;
    const APITOKEN_INVALID = 52;
    const REFRESHTOKEN_EXPIRED = 53;
    const REFRESHTOKEN_INVALID = 54;
    const OPENID_INVALID = 55;

    public function isExpired() {
        return $this->expired_in->lte(now());
    }

    public function getExpiredTime() {
        return $this->expired_in->format('c');
    }

    protected static function tokenGenerate() {
        return sha1(md5(uniqid(md5(microtime(true)),true)));
    }

    public static function getErrorMessage($error) {
        return config('applet.errorcode.' . $error);
    }
}
