<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\PessoaJuridica;
use Exception;

class PessoasJuridicasController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getDados($cnpj)
    {
        $pessoaJuridica = PessoaJuridica::where('cnpj', $cnpj)->first();
        
        if (!empty($pessoaJuridica)) {
            $pessoa['nome'] =  $pessoaJuridica->razao_social;
            $pessoa['fantasia'] =  $pessoaJuridica->nome_fantasia;
            $pessoa['cgf'] =  $pessoaJuridica->cgf;
            $pessoa['cep'] =  $pessoaJuridica->pessoa->cep;
            $pessoa['logradouro'] =  $pessoaJuridica->pessoa->logradouro;
            $pessoa['numero'] =  $pessoaJuridica->pessoa->numero;
            $pessoa['bairro'] =  $pessoaJuridica->pessoa->bairro;
            $pessoa['email'] =  $pessoaJuridica->pessoa->email;
            $pessoa['telefone'] =  $pessoaJuridica->pessoa->telefone;
            $pessoa['celular'] =  $pessoaJuridica->pessoa->celular;
            $pessoa['municipio'] = $pessoaJuridica->pessoa->cidade->nome;
            $pessoa['uf'] = $pessoaJuridica->pessoa->cidade->estado->sigla;
            return response()->json(['success' => true, 'pessoa' => $pessoa]);
        }

        try {
            $url = "https://www.receitaws.com.br/v1/cnpj/{$cnpj}";
            $response = file_get_contents($url);
            $pessoa = json_decode($response);  
            return response()->json(['success' => true, 'pessoa' => $pessoa]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'pessoa' => null]);
        }
    }
}
