<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends BaseModel
{
    //
    protected $table = 'user_alert';

    public function user() {
        return $this->belongsTo('App\User');
    }
}
