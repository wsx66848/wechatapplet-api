<?php

namespace App\Http\Controllers\Api;

use App\Models\MarkPoint;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarkPointController extends Controller
{
    //

    public function markpointSubscription(Request $request, MarkPoint $markpoint) {
        $subscription = new Subscription;
        $user = $request->user();
        $subscription->markpoint_id = $markpoint->id;
        $subscription->name = $markpoint->name;
        $subscription->user_id = $user->id;
        $subscription->save();
        return $this->success();
    }

    public function getCards(Request $request, MarkPoint $markpoint) {
        return $this->success($markpoint->cards);
    }
}
