<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Card extends BaseModel
{
    //
    protected $table = 'card';

    protected $dateFormat = 'Y-m-d H:i:s';
    protected $dates = [
        'created_at',
        'updated_at',
        'lastUpdatetime',
    ];

    protected $appends = ['collected'];

    public function getCollectedAttribute() {
        $user = Auth::user();
        return $this->getUserCollection($user) ? true : false;

    }

    public function markpoint() {
        return $this->belongsTo('App\Models\MarkPoint');
    }

    public function collections() {
        return $this->morphMany('App\Models\Collection', 'collectionable');
    }

    public function getUserCollection($user = null) {
        if($user) {
            $collections = $this->collections;
            $this->addHidden('collections');
            foreach($collections as $collection) {
                if($collection->user->getKey() == $user->getKey()) {
                    return $collection;
                }
            }
        }
        return false;

    }


}
