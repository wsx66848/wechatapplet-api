<?php

namespace App\Services\Providers;

use Illuminate\Support\Str;
use Illuminate\Auth\EloquentUserProvider as Base;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use App\Exceptions\TokenException;
use App\Models\Token\BaseToken;

class EloquentUserProvider extends Base {


    public function retrieveByCredentials(array $credentials) {
        if (empty($credentials) ||
           (count($credentials) === 1 &&
            array_key_exists('password', $credentials))) {
            return;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->createModel()->newQuery();

        foreach ($credentials as $key => $value) {
            if (! Str::contains($key, 'password')) {
                $query->where($key, $value);
            }
        }

        $token = $query->first();
        if(!$token) {
            throw new TokenException(BaseToken::getErrorMessage(BaseToken::APITOKEN_INVALID), BaseToken::APITOKEN_INVALID);
        }

        if($token->isExpired()) {
            throw new TokenException(BaseToken::getErrorMessage(BaseToken::APITOKEN_EXPIRED), BaseToken::APITOKEN_EXPIRED);
        }

        return $token->user;

    }

}
