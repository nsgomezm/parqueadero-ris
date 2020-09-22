<?php

use App\Models\Personal_information;
use App\Models\User;
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


Route::get('/admins/get', function(){
    return response()->json([
        'users' => User::with('personal_information')->where('status', '=', 'activo')->get()
    ]);
});

Route::get('/validate/cedula/{number}', function($number){
    return Personal_information::with('user')->where('cedula', '=', $number)->get();
});

Route::get('/validate/nickname/{data}', function($data){
    return User::where('nickname', '=', $data)->get();
});

Route::get('/validate/email/{data}', function($data){
    return User::where('email', '=', $data)->get();
});
