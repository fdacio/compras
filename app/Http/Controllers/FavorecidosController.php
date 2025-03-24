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

class 
