<?php

namespace App\Http\Controllers;

use App\Models\Personal_information;
use App\Models\User;
use Faker\Provider\ar_JO\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function index(){
        $users = User::with('personal_information', 'roles')->get();
        return view('user/list', compact('users'));
    }

    function form(User $User = null){
        if($User == null){
            $user = Auth::user()->load('personal_information');
        }else{
            $user = $User;
        }

        return view('user/form', compact('user'));
    }

    function setPhoto(Personal_information $personal_information, Request $request){
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = '/images/persons/admins/' . $personal_information->cedula.'.'. request()->avatar->getClientOriginalExtension();

        request()->avatar->move(public_path('/images/persons/admins'), $imageName);
        $personal_information->photo = $imageName;
        $personal_information->update();

        return response()->json([
            true
            // $personal_information,
            // $request
        ]);

    }

    function setUser(User $user = null, Request $request){

        if($user != null){
            $user->update($request->all());

            return response()->json([
                'title' => 'Se actualizó',
                'menssage' => 'La información personal se actualizó correctamente'
            ]);
        }

        // dd($request);

        $inser =  new User($request->all());
        $inser->save();

        return response()->json([
            'result' => $request->email
            // $insert
        ]);
    }

    function setPersonalInformation(Personal_information $Personal_information, Request $request){

        $Personal_information->update($request->all());
        return response()->json([
            true
        ]);
    }



}
