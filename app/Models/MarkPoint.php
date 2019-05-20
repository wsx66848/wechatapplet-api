<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkPoint extends Model
{
    //
    protected $table = 'markpoint';

    public function map() {
        return $this->belongsTo('App\Models\Map');
    }

    public function cards() {
        return $this->hasMany('App\Models\Card', 'markpoint_id');
    }
}
