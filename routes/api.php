<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
});

//feedback
Route::apiResource('feedback', 'FeedbackController', ['only' => ['store']]);

//map
Route::apiResource('map', 'MapController', ['only' => [
    'index', 'show'
]]);

//markpoint
Route::post('/markpoint/subscription/add/{markpoint}', 'MarkPointController@addSubscription');
Route::post('/markpoint/subscription/delete/{markpoint}', 'MarkPointController@deleteSubscription');
Route::apiResource('markpoint', 'MarkPointController', ['only' => [
    'index','show'
]]);
//card
Route::post('/card/collection/add/{card}', 'CardController@addCollection');
Route::post('/card/collection/delete/{card}', 'CardController@deleteCollection');
Route::apiResource('card', 'CardController', ['only' => [
    'index', 'show'
]]);

//article
Route::post('/article/collection/add/{article}', 'ArticleController@addCollection');
Route::post('/article/collection/delete/{article}', 'ArticleController@deleteCollection');
Route::apiResource('article', 'ArticleController', ['only' => [
    'index', 'show'
]]);

//collection
Route::apiResource('collection', 'CollectionController', ['only' => [
    'index', 'show'
]]);

//subscription
Route::apiResource('subscription', 'SubscriptionController', ['only' => [
    'index', 'show'
]]);

//alert
Route::post('/alert/edit/{alert}', 'AlertController@editAlert');
Route::post('/alert/delete/{alert}', 'AlertController@deleteAlert');
Route::apiResource('alert', 'AlertController', ['except' => [
    'update', 'destroy',
]]);

