<?php

use Illuminate\Http\Request;
use App\Notification;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('api')->post('/dismiss', function(Request $request) {
    $notification = Notification::find($request->id);
    $notification->read = 1;
    $notification->save();
    return response()->json(['status' => 'done'],200);
})->name('api.dismiss');