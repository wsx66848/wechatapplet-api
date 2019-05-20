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
Route::post('/markpoint/subscription/{markpoint}', 'MarkPointController@markpointSubscription');
Route::get('/markpoint/cards/{markpoint}', 'MarkPointController@getCards');
//card
Route::post('/card/collection/{card}', 'CardController@cardCollection');
Route::apiResource('card', 'CardController', ['only' => [
    'index', 'show'
]]);

//article
Route::post('/article/collection/{article}', 'ArticleController@articleCollection');
Route::apiResource('article', 'ArticleController', ['only' => [
    'index', 'show'
]]);

//collection
Route::post('/collection/delete/{collection}', 'CollectionController@deleteCollection');
Route::apiResource('collection', 'CollectionController', ['only' => [
    'index', 'show'
]]);

//subscription
Route::post('/subscription/delete/{subscription}', 'SubscriptionController@deleteSubscription');
Route::apiResource('subscription', 'SubscriptionController', ['only' => [
    'index', 'show'
]]);

//alert
Route::post('/alert/edit/{alert}', 'AlertController@editAlert');
Route::post('/alert/delete/{alert}', 'AlertController@deleteAlert');
Route::apiResource('alert', 'AlertController', ['except' => [
    'update', 'destroy',
]]);

//map
Route::apiResource('map', 'MapController', ['only' => [
    'index', 'show'
]]);
