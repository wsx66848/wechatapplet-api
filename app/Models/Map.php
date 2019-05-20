<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    //
    protected $table = 'map';

    public function school() {
        return $this->belongsTo('App\Models\School');
    }

    public function markpoints() {
        return $this->hasMany('App\Models\MarkPoint');
    }
}
