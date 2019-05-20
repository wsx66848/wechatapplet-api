<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    //
    protected $table = 'card';

    protected $dateFormat = 'Y-m-d H:i:s';
    protected $dats = [
        'created_at',
        'updated_at',
        'lastUpdatetime',
    ];

    public function markpoint() {
        return $this->belongsTo('App\Models\Card');
    }

    public function collections() {
        return $this->morphMany('App\Models\Collection', 'collectionable');
    }


}
