<?php

use Illuminate\Support\Facades\Route;
//Para acceder a nuestra clase del controlador empleado
use App\Http\Controllers\EmpleadoController;

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
    return view('auth.login');
});

//Ruta que tomara todos los metodos del controlador empleado.
//Para entrar a las rutas tiene que estar autentificado
Route::resource('empleado', EmpleadoController::class)->middleware('auth');

// De esta manera evitamos que aparezcan el registro y la liga reset password.
// Auth::routes(['register'=>false, 'reset'=>false]);

Auth::routes();

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

Route::middleware(['middleware' => 'auth'], function(){
    Route::get('/', [EmpleadoController::class, 'index'])->name('home');
});

