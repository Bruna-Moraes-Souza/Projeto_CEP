<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UsuarioController extends Controller
{
    public function index(){
        return view('usuarios');
    }

    public function salvar (Request $request){
        DB::table ('usuarios')->insert([
            'nome' => $request->nome,
            'email' => $request->email,
            'cep' => $request-> cep,
            'rua' => $request-> rua,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,]);

            return redirect('/usuarios');
        
    }
}
