<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(){
        $customer = Customer::all();
        return Inertia::render('Customers/index', ['customers' => $customer]);
    }

    public function save(Request $request){
        try {
            //dd( $request);
            //validaciones
            $reglas =  array(
                'name' => 'required',
                'lastname' => 'required',
                'document_type' => 'required',
                'id_document' => 'required',
                'email' => 'required',
                'phone' => 'numeric|required',
                'country' => 'required',
                'city' => 'required',
                'address' => 'required',
                'username' => 'required',
                'password' => 'required',
            );
            $mensajes_validacion = [
                'required' => 'El campo :attribute es obligatorio.',
                'numeric' => 'El campo :attribute debe ser numerico.'
            ];
            $validator      = Validator::make((array) $request->all(), $reglas, $mensajes_validacion );
            $errores_lista  = array();
            if ($validator->fails()){
                $errores = (array) $validator->messages();

                foreach ($errores as $error){
                    $error = (array) $error;
                    foreach ($error as $err){
                        if ($err != ":message")array_push($errores_lista, $err[0]);
                    }
                }

                return response()->json(array('success' => false, 'info' => $errores_lista),400);
            }

            if (!$request->ajax()) return redirect('/');
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->lastname = $request->lastname;
            $customer->document_type = $request->document_type;
            $customer->id_document = $request->id_document;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->country = $request->country;
            $customer->city = $request->city;
            $customer->address = $request->address;
            $customer->username = $request->username;
            $customer->password = $request->password;
            $customer->save();

            return response()->json( ['success' => true, 'info' => Customer::all()], 200);
        }catch (\Exception $ex){
            return response()->json( ['success' => false, 'info' => $ex->getMessage()], 400);
        }
    }
    public function update(Request $request){
        try {
            //dd( $request);
            //validaciones
            $reglas =  array(
                'name' => 'required',
                'lastname' => 'required',
                'document_type' => 'required',
                'id_document' => 'required',
                'email' => 'required',
                'phone' => 'numeric|required',
                'country' => 'required',
                'city' => 'required',
                'address' => 'required',
                'username' => 'required',
                'password' => 'required',
                'id'=>'required'
            );
            $mensajes_validacion = [
                'required' => 'El campo :attribute es obligatorio.',
                'numeric' => 'El campo :attribute debe ser numerico.'
            ];
            $validator      = Validator::make((array) $request->all(), $reglas, $mensajes_validacion );
            $errores_lista  = array();
            if ($validator->fails()){
                $errores = (array) $validator->messages();

                foreach ($errores as $error){
                    $error = (array) $error;
                    foreach ($error as $err){
                        if ($err != ":message")array_push($errores_lista, $err[0]);
                    }
                }

                return response()->json(array('success' => false, 'info' => $errores_lista),400);
            }

            if (!$request->ajax()) return redirect('/');
            $customer = Customer::findOrFail($request->id);
            $customer->name = $request->name;
            $customer->lastname = $request->lastname;
            $customer->document_type = $request->document_type;
            $customer->id_document = $request->id_document;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->country = $request->country;
            $customer->city = $request->city;
            $customer->address = $request->address;
            $customer->username = $request->username;
            $customer->password = $request->password;
            $customer->save();

            return response()->json( ['success' => true, 'info' => Customer::all()], 200);
        }catch (\Exception $ex){
            return response()->json( ['success' => false, 'info' => $ex->getMessage()], 400);
        }
    }

    function all(){
        return Customer::all();
    }

    function login($user,$pass){
        return Customer::select('*')
                    ->where(['username'=>$user,'password'=>$pass])
                    ->first();
    }


}
