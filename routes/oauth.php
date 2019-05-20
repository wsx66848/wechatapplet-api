<?php

use Illuminate\Http\Request;

Route::post('/login', "LoginController@login");
Route::post('/refresh-token', "TokenController@refresh");
