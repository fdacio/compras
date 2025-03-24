<?php

namespace App\Http\Controllers;

Use App\Favorecido;
Use App\Http\Requests\FavorecidoPessoaJuridicaRequest;
Use App\Http\Requests\FavorecidoPessoaFisicaRequest;
Use App\Pessoa;
Use App\PessoaFisica;
Use App\PessoaJuridica;
Use App\Uf;
Use App\Municipio;
Use Exception;
Use Illuminate\Support\Facades\DB;

class FavorecidosController extends Controller
{
        @return \Illuminate\Http\Response

    public function index ()
    {
        $favorecidos = Favorecido::orderBy('id', 'asc');
        $tipoPessoas = request()->get('pessoa')
    }





    
}
