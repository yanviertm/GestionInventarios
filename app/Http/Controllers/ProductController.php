<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Models\{Category, Product};
use App\Helpers\General;

class ProductController extends Controller
{

    public function index(){
        $product = Product::all();
        $categories = Category::all();
        return Inertia::render('Articles/index', ['products' => $product, 'categories' => $categories]);
    }

    public function save(Request $request){

        try {
            //dd( $request);
            //validaciones
            $reglas =  array(
                'name' => 'required',
                'id_category' => 'required',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'file' => 'image|required',
            );
            $mensajes_validacion = [
                'required' => 'El campo :attribute es obligatorio.',
                'image' => ':attribute debe ser una imagen.',
                'numeric' => 'El campo :attribute debe ser de tipo numerico.',
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

            $name_img  = md5(time()) . '.' . $request->file->extension();
            $url_img  = url('uploads/' . $name_img);
            $request->file->move(public_path('uploads'), $name_img);
            if (!$request->ajax()) return redirect('/');
            $producto = new Product();
            $producto->id_category = $request->id_category;
            $producto->name = $request->name;
            $producto->price = $request->price;
            $producto->description = $request->description;
            $producto->stock = $request->stock;
            $producto->discount = $request->discount;
            $producto->name_img = $name_img;
            $producto->url_img = $url_img;
            $producto->save();

            return response()->json( ['success' => true, 'info' => Product::all()], 200);
        }catch (\Exception $ex){
            return response()->json( ['success' => false, 'info' => $ex->getMessage()], 400);
        }
    }

    public function update(Request $request){
            try {
                $request_all = (array) $request->all();
                //validaciones
                $reglas              = array(
                    'name' => 'required',
                    'id_category' => 'required',
                    'price' => 'required|numeric',
                    'stock' => 'required|numeric',
                    'id' => 'required',
                );
                $mensajes_validacion = [
                    'required' => 'El campo :attribute es obligatorio.',
                    'numeric' => 'El campo :attribute debe ser de tipo numerico.',
                ];
                $validator = Validator::make($request_all, $reglas, $mensajes_validacion);
                $errores_lista = array();
                if ($validator->fails()) {
                    $errores = (array)$validator->messages();

                    foreach ($errores as $error) {
                        $error = (array)$error;
                        foreach ($error as $err) {
                            if ($err != ":message") array_push($errores_lista, $err[0]);
                        }
                    }

                    return response()->json(array('success' => false, 'info' => $errores_lista), 400);
                }

            $producto = Product::findOrFail($request->id);
            $producto->id_category = $request->id_category;
            $producto->name = $request->name;
            $producto->price = $request->price;
            $producto->description = $request->description;
            $producto->discount = $request->discount;
            $producto->stock = $request->stock;
            $producto->save();

            return response()->json( ['success' => true, 'info' => Product::all()], 200);
        }catch (\Exception $ex){
            return response()->json( ['success' => false, 'info' => $ex->getMessage()], 400);
        }
    }

    public function delete($id){
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json( ['success' => true, 'info' => Product::all()], 200);
    }

    public function all(Request $request){
        return Product::all();
    }
}
