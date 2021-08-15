<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{DashboardController, ProductController,CategoryController, CustomerController};

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

Route::get('/', function () {
    return view('auth/login');
});

/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');*/

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::get('/productos',[ProductController::class, 'index']);
Route::post('/productos/registrar',[ProductController::class, 'save']);
Route::post('/productos/actualizar',[ProductController::class, 'update']);
Route::delete('/productos/eliminar/{id}',[ProductController::class, 'delete']);

Route::get('/categorias',[CategoryController::class, 'index']);
Route::post('/categorias/registrar',[CategoryController::class, 'save']);
Route::put('/categorias/actualizar',[CategoryController::class, 'update']);
Route::delete('/categorias/eliminar/{id}',[CategoryController::class, 'delete']);

Route::get('/clientes',[CustomerController::class,'index']);
Route::post('/clientes/registrar',[CustomerController::class,'save']);
Route::put('/clientes/actualizar',[CustomerController::class,'update']);
Route::delete('/clientes/eliminar/{id}',[CustomerController::class,'delete']);

Route::get('/ventas',[\App\Http\Controllers\SalesController::class,'index']);




