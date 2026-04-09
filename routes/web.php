<?php

// Importa a classe Route para definir as rotas da aplicação
use Illuminate\Support\Facades\Route;
// Importa o controller de usuários
use App\Http\Controllers\UsuarioController;

// Rota GET: Exibe o formulário de cadastro quando acessa /usuarios
Route::get ('/usuarios',[UsuarioController::class, 'index']);
// Rota POST: Processa o envio do formulário para salvar os dados
Route::post('/usuarios/salvar',[UsuarioController::class, 'salvar']);

Route::get('/', function () {
    return view('welcome');
});
