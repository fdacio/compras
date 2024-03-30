<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\PessoaFisica;

class PessoasFisicasController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getDados($cpf)
    {
        $pessoaFisica = PessoaFisica::where('cpf', $cpf)->first();
        
        if (!empty($pessoaFisica)) {
            $dados['nome'] =  $pessoaFisica->nome;
            $dados['rg'] =  $pessoaFisica->rg;
            $dados['rg_orgao'] =  $pessoaFisica->rg_orgao;
            $dados['rg_emissao'] =  Carbon::parse($pessoaFisica->rg_emissao)->format('d/m/Y');
            $dados['nascimento'] =  Carbon::parse($pessoaFisica->nascimento)->format('d/m/Y');
            $dados['sexo'] =  $pessoaFisica->sexo;
            $dados['cep'] =  $pessoaFisica->pessoa->cep;
            $dados['logradouro'] =  $pessoaFisica->pessoa->logradouro;
            $dados['numero'] =  $pessoaFisica->pessoa->numero;
            $dados['bairro'] =  $pessoaFisica->pessoa->bairro;
            $dados['email'] =  $pessoaFisica->pessoa->email;
            $dados['telefone'] =  $pessoaFisica->pessoa->telefone;
            $dados['celular'] =  $pessoaFisica->pessoa->celular;
            $dados['municipio'] = $pessoaFisica->pessoa->cidade->nome;
            $dados['uf'] = $pessoaFisica->pessoa->cidade->estado->sigla;
            $dados['ponto_referencia'] = $pessoaFisica->pessoa->ponto_referencia;
            return response()->json($dados);
        }

        return response()->json([]);

    } 
}
