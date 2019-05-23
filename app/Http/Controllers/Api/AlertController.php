<?php

namespace App\Http\Controllers\Api;

use App\Models\Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use App\Exceptions\ModelException;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user = $request->user();
        $alerts = $user->alerts;
        return $this->success($alerts);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = $request->user();
        return Response::apiWithTransaction([
            'content' => 'required',
        ], [], function($d) use($user) {
            $content = $d['content'];
            $alert = new Alert;
            $alert->content = $content;
            $alert->user_id = $user->id;
            $alert->save();
            return true;
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Alert $alert)
    {
        //
        $user = $request->user();
        if ($alert->user->id != $user->id) {
            throw new ModelException('no authorization', 403);
        }
        return $this->success($alert);
        
    }

    public function editAlert(Request $request, Alert $alert) {
        $user = $request->user();
        if ($alert->user->id != $user->id) {
            throw new ModelException('no authorization', 403);
        }
        return Response::apiWithTransaction([
            'content' => 'required'
        ], [], function($d) use($alert) {
            $alert->content = $d['content'];
            $alert->save();
            return true;
        });
    }

    public function deleteAlert(Request $request, Alert $alert) {
        $user = $request->user();
        if ($alert->user->id != $user->id) {
            throw new ModelException('no authorization', 403);
        }
        return Response::apiWithTransaction([
        ], [], function($d) use($alert) {
            $alert->delete();
            return true;
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function edit(Alert $alert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alert $alert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alert $alert)
    {
        //
    }
}
