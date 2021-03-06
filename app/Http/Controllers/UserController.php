<?php

namespace App\Http\Controllers;

use App\Models\Personal_information;
use App\Models\User;
use Faker\Provider\ar_JO\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index(){
        if(Auth::user()->hasRole('S.Admin')){
            $users = User::with('personal_information', 'roles')->get();
        }else if(Auth::user()->hasRole('Admin')){
            $users = User::with('personal_information', 'roles')->get();
        }
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

        if($user != null){
            $user->update($data);
            $user->syncRoles($Request->roles[0]['name']);
            return response()->json([
                'title' => 'Se actualizó',
                'menssage' => 'La información personal se actualizó correctamente'
            ]);
        }

        try{
            DB::beginTransaction();
            $user = new User($Request->except($Request->cedula));
            $user->save();
            $user
                ->personal_information()
                ->save(new Personal_information($Request->personal_information));

            $user->assignRole('patio');
            $user->load('roles');
            DB::commit();
            return response()->json([
                'title' => 'Se guardo exitosamente',
                'menssage' => '',
                'user' => $user,
                'error' => false
            ]);

        } catch (\Exception $error){
            DB::rollback();
            return response()->json([
                'title' => 'Error',
                'menssage' => 'No se guardo, error',
                'cedula' => $Request->personal_information,
                'error' => $error
            ]);
        }
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
