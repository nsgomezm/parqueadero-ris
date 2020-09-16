<?php

namespace App\Http\Controllers;

use App\Models\Personal_information;
use App\Models\User;
use Faker\Provider\ar_JO\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index(){
        $users = User::with('personal_information', 'roles')->get();
        return view('user/list', compact('users'));
    }

    function form(User $User = null){
        if($User == null){
            $user = Auth::user()->load('personal_information', 'roles');
        }else{
            $user = $User->load('roles');
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
        ]);

    }

    function setUser(User $user = null, Request $Request){
        $data = request()->all();

        // return response()->json([
            // $Request->roles[0]
        // ]);

        if($user != null){
            $user->update($data);
            $user->syncRoles($Request->roles[0]['name']);
            return response()->json([
                'title' => 'Se actualizó',
                'menssage' => 'La información personal se actualizó correctamente'
            ]);
        }

        $user = new User($data);
        $user->save();
        return response()->json([
            'title' => 'Nuevo Usuario',
            'menssage' => 'Se creo un nuevo usuario',
            'result' => $data
            // $insert
        ]);
    }

    function setPersonalInformation(Personal_information $Personal_information, Request $request){

        $Personal_information->update($request->all());
        return response()->json([
            true
        ]);
    }

    function setPassword(User $user, Request $request){

        if (Hash::check($request->old, $user->password)){

            $user->password = Hash::make($request->new);
            $user->save();

            return response()->json([
                'update' => true,
                'title' => 'Contraseñas actualizadas',
                'menssage' => 'La contraseña fue actualizada con exito.',
                'alert' => 'success',
            ]);
        }

        return response()->json([
            'update' => false,
            'title' =>  'Credenciales incorrectas',
            'menssage' => 'Las contraseña actual es incorrecta',
            'alert' => 'warning',
        ]);
    }

    function deleteUser(User $user){
        $user->delete();

        return response()->json([
            'users' => User::with('personal_information', 'roles')->get()
        ]);
    }
}
