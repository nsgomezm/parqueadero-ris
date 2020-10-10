<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    function index(){
        $customers =  Customer::with('parking')->get();

        return view('monthly/customers', compact('customers'));
    }

    function form(Customer $customer){
        $customer->load('parking');
        return view('monthly/form', compact('customer'));
    }

    function deleteCustomer(Customer $customer){
        $customer->delete();
        $customers =  Customer::with('parking')->get();

        return response()->json([
            'customer' => $customer,
            'customers' => $customers,
        ]);
    }

    function setCustomer(Customer $customer = null, Request $request){
        if($customer != null){
            $customer->update( $request->all() );

            return response()->json([
                'title' => 'Se esta actualizando',
                'menssage' => 'Actualizando',
            ]);
        }

        $customer = new Customer($request->all());
        $customer->save();

        return response()->json([
            'title' => 'Creación exitosa',
            'menssage' => 'Se creo el nuevo parqueadero',
            'customer' => $customer
        ]);
    }
}
