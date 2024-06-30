<?php

namespace App\Http\Controllers;

use App\CentroCusto;
use App\RequisicaoCompra;
use App\Solicitante;
use App\Veiculo;
use Illuminate\Http\Request;

class RequisicoesComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requisitantes = CentroCusto::orderBy('nome', 'asc')->pluck('nome', 'id');

        $solicitantes = Solicitante::orderBy('nome', 'asc')->pluck('nome', 'id');

        $veiculos = Veiculo::get()->map(function($veiculo) {
            return ['id' => $veiculo->id, 'descricao' => 'Placa: ' . $veiculo->placa . ' - ' . $veiculo->marca . ' - ' . $veiculo->modelo];
        })->sortBy('descricao')->pluck('descricao', 'id');

        return view('requisicoes-compras.index', compact('requisitantes', 'solicitantes', 'veiculos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $requisitantes = CentroCusto::orderBy('nome', 'asc')->pluck('nome', 'id');

        $solicitantes = Solicitante::orderBy('nome', 'asc')->pluck('nome', 'id');

        $veiculos = Veiculo::get()->map(function($veiculo) {
            return ['id' => $veiculo->id, 'descricao' => 'Placa: ' . $veiculo->placa . ' - ' . $veiculo->marca . ' - ' . $veiculo->modelo];
        })->sortBy('descricao')->pluck('descricao', 'id');

        $tipos = collect(RequisicaoCompra::TIPOS)->map(function($tipo) {
            return ['tipo' => $tipo['value'], 'descricao' => $tipo['label']];
        })->pluck('descricao', 'tipo');

        return view('requisicoes-compras.create', compact('requisitantes', 'solicitantes', 'veiculos', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        print_r($request->all()); die();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
