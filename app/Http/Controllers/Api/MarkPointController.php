<?php

namespace App\Http\Controllers\Api;

use App\Models\MarkPoint;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class MarkPointController extends Controller
{
    //

    public function addSubscription(Request $request, MarkPoint $markpoint) {
        $user = $request->user();
        if(! $markpoint->getUserSubscription($user)) {
        $subscription = new Subscription;
        $subscription->markpoint_id = $markpoint->id;
        $subscription->name = $markpoint->name;
        $subscription->user_id = $user->id;
        $subscription->save();
        }
        return $this->success();
    }

    public function deleteSubscription(Request $request, MarkPoint $markpoint) {
        $user = $request->user();
        if($subscription = $markpoint->getUserSubscription($user)) {
            $subscription->delete();
        }
        return $this->success();

    }

    public function index()
    {
        //
        return $this->success(MarkPoint::with('cards')->get());
    }

    public function show(MarkPoint $markpoint)
    {
        //
        $markpoint->cards = $markpoint->cards()->get();
        return $this->success($markpoint);
    }
}
