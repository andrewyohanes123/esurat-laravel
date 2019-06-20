<?php

use Illuminate\Http\Request;
use App\Department;
use App\DispositionRelation;
use App\User;

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

Route::group(['middleware' => 'api_token'], function () {
   Route::get('/departments', function(){
       $depts = Department::all();
       return response()->json($depts);
   });
   Route::get('/departments/{id}', function($id){
       $dept = Department::findOrFail($id);
       return response()->json($dept);
   });
   Route::put('/department/{id}', function($id, Request $request){
       $status = Department::whereId($id)->update(['permissions' => serialize($request->permissions)]);
       if ($status) {
           return response()->json(['msg' => 'OK', 'status' => true]);
        } else {
            return response()->json(['msg' => 'Error', 'status' => false]);
       }
   });
   Route::get('/notifications', function (Request $request){
       $user = User::where('api_token', $request->header('USER-TOKEN'))->get()->first();
       $notifications = DispositionRelation::where('to_user', $user->id)->take(10)->get()->load(['from_user', 'to_user', 'disposition_message', 'disposition']);
       return ['data' => $notifications, 'count' => $notifications->count()];
    //    return ['token' => $request->header('USER-TOKEN')];
   });
   Route::get('setting', function(){
       $setting = \App\Setting::orderBy('id', 'DESC')->get()->first();
       return response()->json($setting);
   });
});
