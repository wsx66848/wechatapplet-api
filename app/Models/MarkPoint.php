<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class MarkPoint extends BaseModel
{
    //
    protected $table = 'markpoint';

    protected $appends = ['subscribed'];

    public function getSubscribedAttribute() {
        $user = Auth::user();
        return $this->getUserSubscription($user) ? true : false;
    }
    
    public function map() {
        return $this->belongsTo('App\Models\Map');
    }

    public function cards() {
        return $this->hasMany('App\Models\Card', 'markpoint_id');
    }

    public function subscriptions() {
        return $this->hasMany('App\Models\Subscription', 'markpoint_id');
    }

    public function getUserSubscription($user = null) {
        if($user) {
            $subscriptions = $this->subscriptions;
            foreach($subscriptions as $subscription) {
                if($subscription->user->getKey() == $user->getKey()) {
                    return $subscription;
                }
            }
        }
        return false;
    }

}
