<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Article extends BaseModel
{
    //
    protected $table = 'article';
    protected $appends = ['collected'];

    public function getCollectedAttribute() {
        $user = Auth::user();
        return $this->getUserCollection($user) ? true : false;

    }

    public function collections() {
        return $this->morphMany('App\Models\Collection', 'collectionable');
    }

    public function getUserCollection($user = null) {
        if($user) {
            $collections = $this->collections;
            foreach($collections as $collection) {
                if($collection->user->getKey() == $user->getKey()) {
                    return $collection;
                }
            }
        }
        return false;
    }
}
