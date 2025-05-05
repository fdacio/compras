<?php

namespace App\Http\Controllers;

use App\CentroCusto;
use App\RequisicaoCompra;
use App\Solicitante;
use App\User;
use App\Veiculo;


class RequisicoesComprasExternasController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::findOrFail(auth()->user()->id);
        $centrosCustosUser = $user->centrosCustos()->pluck('id_centro_custo')->toArray();
        $requisicoes = RequisicaoCompra::whereIn('id_requisitante', $centrosCustosUser)->orderBy('id', 'desc');
        

        $requisitante = request()->get('id_requisitante');
        $solicitante = request()->get('id_solicitante');
        $veiculo = request()->get('id_veiculo');

        if (!empty($requisitante)) {
            $requisicoes =  $requisicoes->where('id_requisitante', $requisitante);
        }

        if (!empty($solicitante)) {
            $requisicoes =  $requisicoes->where('id_solicitante', $solicitante);
        }

        if (!empty($veiculo)) {
            $requisicoes =  $requisicoes->where('id_veiculo', $veiculo);
        }

        $requisitantes = CentroCusto::whereIn('id', $centrosCustosUser)->orderBy('nome', 'asc')->pluck('nome', 'id');
        $solicitantes = Solicitante::orderBy('nome', 'asc')->pluck('nome', 'id');
        $veiculos = Veiculo::get()->map(function ($veiculo) {
            return ['id' => $veiculo->id, 'descricao' => 'Placa: ' . $veiculo->placa . ' - ' . $veiculo->marca . ' - ' . $veiculo->modelo];
        })->sortBy('descricao')->pluck('descricao', 'id');

        $requisicoes = $requisicoes->paginate(10);

        return view('requisicoes-compras-externas.index', compact('requisicoes', 'requisitantes', 'solicitantes', 'veiculos'));
    }


}
