<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends BaseModel
{
    //
    protected $table = 'subscription';

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function markpoint() {
        return $this->belongsTo('App\Models\MarkPoint', 'markpoint_id');
    }
}
