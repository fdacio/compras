<?php

namespace App\Http\Controllers\Api;

use App\Empresa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pessoa;

class EmpresasController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function empresas(Request $request)
    {
        $tipoPessoa = $request->tipo_pessoa;
        $nomeRazaoSocial = $request->nome_razao_social;

        if (empty($tipoPessoa) && empty($nomeRazaoSocial)) {
            $empresas = Empresa::with(['pessoa' => function ($query) {
                $query->with('pessoaFisica', 'pessoaJuridica');
            }])->get();
            return response()->json($empresas);
        }


        if (!empty($tipoPessoa) && $tipoPessoa == Pessoa::TIPO_PESSOA_FISICA) {
            $empresas = Empresa::whereHas('pessoa', function ($query) use ($nomeRazaoSocial) {
                $query->whereHas('pessoaFisica', function($query) use ($nomeRazaoSocial) {
                    $query->where('nome', 'like', "%$nomeRazaoSocial%");
                });
            })->with('pessoa')->get();

            return response()->json($empresas);
        } 
        
        if (!empty($tipoPessoa) && $tipoPessoa == Pessoa::TIPO_PESSOA_JURIDICA) {
            $empresas = Empresa::whereHas('pessoa', function ($query) use ($nomeRazaoSocial) {
                $query->whereHas('pessoaJuridica', function($query) use ($nomeRazaoSocial) {
                    $query->where('razao_social', 'like', "%$nomeRazaoSocial%");
                });
            })->with('pessoa')->get();
            return response()->json($empresas);
        }

    }

    public function empresa($cnpjCpf)
    {
        if (strlen($cnpjCpf) == 11) {
            
            $empresa = Empresa::whereHas('pessoa', function ($query) use ($cnpjCpf) {
                $query->whereHas('pessoaFisica', function($query) use ($cnpjCpf) {
                    $query->where('cpf', $cnpjCpf);
                });
            })->with('pessoa')->first();

            return response()->json($empresa);
        }

        if (strlen($cnpjCpf) == 14) {
            
            $empresa = Empresa::whereHas('pessoa', function ($query) use ($cnpjCpf) {
                $query->whereHas('pessoaJuridica', function($query) use ($cnpjCpf) {
                    $query->where('cnpj', $cnpjCpf);
                });
            })->with('pessoa')->first();

            return response()->json($empresa);
        }
        
    }
}
