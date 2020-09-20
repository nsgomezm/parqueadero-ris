<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    function index(){

        $parkings =  Parking::with('user.personal_information')->get();
        return view('parking/list', compact('parkings'));
    }

    function form(Parking $parking){

        return view('parking/form', compact('parking'));
    }

    function setParking(Parking $parking = null, Request $request){
        if($parking != null){
            $parking->update( $request->all() );

            return response()->json([
                'title' => 'Se esta actualizando',
                'menssage' => 'Actualizando',
            ]);
        }

        $parking = new Parking($request->all());
        $parking->save();

        return response()->json([
            'title' => 'Creación exitosa',
            'menssage' => 'Se creo el nuevo parqueadero',
            'parkings' => Parking::with('user.personal_information')->get()
        ]);
    }

    function deleteParking(Parking $parking){
        $parking->delete();

        return response()->json([
            'parkings' => Parking::with('user.personal_information')->get()
        ]);
    }
}
