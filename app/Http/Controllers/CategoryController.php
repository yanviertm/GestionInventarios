<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CategoryController extends Controller
{
    //
    public function index(){
        $categories = Category::all();
        return Inertia::render('Category/index', ['categories' => $categories]);
    }//
    public function save(Request $request){
        try {
            //dd( $request);
            //validaciones
            $reglas =  array(
                'name' => 'required',
            );
            $mensajes_validacion = [
                'required' => 'El campo :attribute es obligatorio.'
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
            $categoria = new Category();
            $categoria->name = $request->name;
            $categoria->description = $request->description;
            $categoria->save();

            return response()->json( ['success' => true, 'info' => Category::all()], 200);
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
                'id' => 'required',
            );
            $mensajes_validacion = [
                'required' => 'El campo :attribute es obligatorio.'
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
            $categoria = Category::findOrFail($request->id);
            $categoria->name = $request->name;
            $categoria->description = $request->description;
            $categoria->save();

            return response()->json( ['success' => true, 'info' => Category::all()], 200);
        }catch (\Exception $ex){
            return response()->json( ['success' => false, 'info' => $ex->getMessage()], 400);
        }
    }

    public function delete($id){
        $categoria = Category::findOrFail($id);
        $categoria->delete();
        return response()->json( ['success' => true, 'info' => Category::all()], 200);
    }
}
