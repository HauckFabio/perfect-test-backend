<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//
class VendaController extends Controller
{
    public function index()
    {
        
        //$hello = 'Hello World!';
        return view('hello.telaInicial');
            
    }

    public function cadastroVenda()
    {
        
        return view('cadastro.cadastrarVenda');
            
    }
}