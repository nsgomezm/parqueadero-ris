<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\Parking;
use App\Models\Personal_information;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::prefix('/test')->group(function () {
    Route::get('/user', function () {
        $user = New User();
        $user->nickname = "nsgomez02";
        $user->email = "nsgomez02@misena.edu.com";
        $user->password = bcrypt("123456");
        $user->status = "activo";
        $user->save();
    });

    Route::get('/information', function(){
        $information = New Personal_information();
        $information->cedula = "1088358516";
        $information->name = "Nicol Steeven";
        $information->last_name = "Gómez Marín";
        $information->cel = "3135504351";
        $information->address = "cll 17 av rio";
        $information->user_id = '1';
        $information->save();
    });

    Route::get('/parking', function(){
        $parking = new Parking();
        $parking->nit ="9876154321";
        $parking->name = "parqueadero la 28";
        $parking->cel = "3333333";
        $parking->address = "carrera 6 N 28-68";
        $parking->user_id = "1";
        $parking->save();

    });

    Route::get('/roles', function(){
        Role::create(['name' => 'S.Admin']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'patio']);
    });

    Route::get('/rol', function(){
        // $user = Auth::user();
        $user = User::find("1");
        // $user->removeRole('Admin');
        $user->assignRole('S.Admin');
        // return $user->getRoleNames();
        return $user;
    });

    Route::get('/', function(){
        // return Parking::with('user.personal_information')->get();
        return User::with('Personal_information', 'roles', 'parking')->get();


        // return Personal_information::with('user')->get();
    });
});


// login
Route::view('/', 'login')->name('login');
Route::post('/', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');


    Route::prefix('/users')->group(function () {
        Route::get('/list', 'UserController@index')->name('user.list');
        Route::get('/edit-information/{user?}', 'UserController@form')->name('user.form');

        Route::post('/edit-information/photo/{personal_information?}', 'UserController@setPhoto');
        Route::post('/edit-information/user/{user?}', 'UserController@setUser');
        Route::post('/edit-information/personal-information/{Personal_information}', 'UserController@setPersonalInformation');
        Route::post('/edit-information/change-password/{user}', 'UserController@setPassword');
        Route::post('/edit-information/delete/{user}', 'UserController@deleteUser');
    });

    Route::prefix('/Parking')->group(function(){
        Route::get('/list', 'ParkingController@index')->name('parking.list');
        Route::get('/edit-information/{parking}', 'ParkingController@form')->name('parking.form');

        Route::post('/edit-information/set/{parking?}', 'ParkingController@setParking');
        Route::post('/edit-information/delete/{parking}', 'ParkingController@deleteParking');


    });




});

