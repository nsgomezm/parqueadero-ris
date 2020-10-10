<?php

use App\Models\Customer;
use App\Models\Parking;
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

Route::get('/parking/get', function(){
    return response()->json([
        'parkings' => Parking::get()
    ]);
});

Route::group(['prefix' => '/validate'], function () {
    Route::get('/cedula/{number}', function($number){
        return Personal_information::with('user')->where('cedula', '=', $number)->get();
    });

    Route::get('/nickname/{data}', function($data){
        return User::where('nickname', '=', $data)->get();
    });

    Route::get('/email/{data}', function($data){
        return User::where('email', '=', $data)->get();
    });

    Route::get('/nit/{data}', function($data){
        return Parking::where('nit', '=', $data)->get();
    });

    Route::get('/cedul/{number}', function($number){
        return Customer::where('cedula', '=', $number)->get();
    });
});

