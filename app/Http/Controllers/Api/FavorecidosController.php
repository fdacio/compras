<?php

namespace App\Http\Controllers\Api;

use App\Favorecido;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pessoa;

class FavorecidosController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function favorecidos(Request $request)
    {
        $tipoPessoa = $request->tipo_pessoa;
        $nomeRazaoSocial = $request->nome_razao_social;

        if (empty($tipoPessoa) && empty($nomeRazaoSocial)) {
            $favorecidos = Favorecido::with(['pessoa' => function ($query) {
                $query->with('pessoaFisica', 'pessoaJuridica');
            }])->get();
            return response()->json($favorecidos);
        }


        if (!empty($tipoPessoa) && $tipoPessoa == Pessoa::TIPO_PESSOA_FISICA) {
            $favorecidos = Favorecido::whereHas('pessoa', function ($query) use ($nomeRazaoSocial) {
                $query->whereHas('pessoaFisica', function($query) use ($nomeRazaoSocial) {
                    $query->where('nome', 'like', "%$nomeRazaoSocial%");
                });
            })->with('pessoa')->get();

            return response()->json($favorecidos);
        } 
        
        if (!empty($tipoPessoa) && $tipoPessoa == Pessoa::TIPO_PESSOA_JURIDICA) {
            $favorecidos = Favorecido::whereHas('pessoa', function ($query) use ($nomeRazaoSocial) {
                $query->whereHas('pessoaJuridica', function($query) use ($nomeRazaoSocial) {
                    $query->where('razao_social', 'like', "%$nomeRazaoSocial%");
                });
            })->with('pessoa')->get();
            return response()->json($favorecidos);
        }

    }

    public function favorecido($cnpjCpf)
    {
        if (strlen($cnpjCpf) == 11) {
            
            $favorecido = Favorecido::whereHas('pessoa', function ($query) use ($cnpjCpf) {
                $query->whereHas('pessoaFisica', function($query) use ($cnpjCpf) {
                    $query->where('cpf', $cnpjCpf);
                });
            })->with('pessoa')->first();

            return response()->json($favorecido);
        }

        if (strlen($cnpjCpf) == 14) {
            
            $favorecido = Favorecido::whereHas('pessoa', function ($query) use ($cnpjCpf) {
                $query->whereHas('pessoaJuridica', function($query) use ($cnpjCpf) {
                    $query->where('cnpj', $cnpjCpf);
                });
            })->with('pessoa')->first();

            return response()->json($favorecido);
        }

    }
}
