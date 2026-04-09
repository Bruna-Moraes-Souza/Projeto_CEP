<?php

// Namespace: Define que esta classe pertence ao grupo de Controllers da aplicação
namespace App\Http\Controllers;

// Importa a classe Request para capturar dados do formulário
use Illuminate\Http\Request;
// Importa a classe DB para executar queries SQL
use Illuminate\Support\Facades\DB;
// Define a classe UsuarioController para gerenciar operações com usuários
class UsuarioController extends Controller
{
    // Função que exibe o formulário de cadastro de usuários
    public function index(){
        return view('usuarios'); // Retorna a view usuarios.blade.php
    }

    // Função que recebe os dados do formulário e salva no banco de dados
    public function salvar (Request $request){
        // Insere os dados na tabela 'usuarios'
        DB::table ('usuarios')->insert([
            'nome' => $request->nome,          // Captura o nome do formulário
            'email' => $request->email,        // Captura o email
            'cep' => $request-> cep,           // Captura o CEP
            'rua' => $request-> rua,           // Captura a rua (preenchida pela API ViaCEP)
            'bairro' => $request->bairro,      // Captura o bairro
            'cidade' => $request->cidade,      // Captura a cidade
            'estado' => $request->estado,      // Captura o estado/UF
        ]);

        // Redireciona para a página de usuários após salvar
        return redirect('/usuarios');
        
    }
}
