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
    
    if (strpos($request->id, ',')) {
        $data = explode(',', $request->id);
        // $data[0] = 'ID of the user';
        // $data[1] = 'User Type';
        $notifications = Notification::where([['rel_with','=',$data[1]],['rel_id','=',$data[0]]])->get();
        foreach ($notifications as $notification) {
            $notification->read = 1;
            $notification->save();
        }
        return response()->json(['status' => 'all'],200);

    } else {
        $notification = Notification::find($request->id);
        $notification->read = 1;
        $notification->save();
        return response()->json(['status' => 'done'],200);
    }
    
})->name('api.dismiss');