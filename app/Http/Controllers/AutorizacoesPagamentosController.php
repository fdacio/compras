<?php

namespace App\Http\Controllers;

use App\AutorizacaoPagamento;
use App\Favorecido;
use App\Veiculo;
use Illuminate\Http\Request;

class AutorizacoesPagamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $autorizacoes = AutorizacaoPagamento::orderBy('id', 'desc');
        $favorecido = request()->get('id_favorecido');
        $veiculo = request()->get('id_veiculo');

        if (!empty($favorecido)) {
            $autorizacoes =  $autorizacoes->where('id_favorecido', $favorecido);
        }
        if (!empty($veiculo)) {
            $autorizacoes =  $autorizacoes->where('id_veiculo', $veiculo);
        }

        $favorevidos = Favorecido::orderBy('nome', 'asc')->pluck('nome', 'id');
        $veiculos = Veiculo::get()->map(function($veiculo) {
            return ['id' => $veiculo->id, 'descricao' => 'Placa: ' . $veiculo->placa . ' - ' . $veiculo->marca . ' - ' . $veiculo->modelo];
        })->sortBy('descricao')->pluck('descricao', 'id');

        $autorizacoes = $autorizacoes->paginate(10);

        return view('autorizacoes-pagamentos.index', compact('autorizacoes', 'favorecidos', 'veiculos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
