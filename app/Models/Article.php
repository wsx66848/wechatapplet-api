<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $table = 'article';

    public function collections() {
        return $this->morphMany('App\Models\Collection', 'collectionable');
    }
}
