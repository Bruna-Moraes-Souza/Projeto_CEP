<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
Route::get ('/usuarios',[UsuarioController::class, 'index']);
Route::post('/usuarios/salvar',[UsuarioController::class, 'salvar']);

Route::get('/', function () {
    return view('welcome');
});
