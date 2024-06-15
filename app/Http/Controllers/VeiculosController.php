<?php

namespace App\Http\Controllers;

use App\CentroCusto;
use App\Empresa;
use App\Frota;
use App\Http\Requests\VeiculoRequest;
use App\TipoVeiculo;
use App\Veiculo;
use Exception;

use function Psy\debug;

class VeiculosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $veiculos = Veiculo::orderBy('placa', 'asc');
        $placa = request()->get('placa');
        if (!empty($placa)) {
            $veiculos =  $veiculos->where('placa', $placa);
        }
        $veiculos = $veiculos->paginate(10);
        return view('veiculos.index', compact('veiculos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $frotas = Frota::orderBy('nome', 'asc')->pluck('nome', 'id');
        $empresas = Empresa::get()->map(function ($empresa) {
            return ['id' => $empresa->id, 'nome_razao_social' => $empresa->pessoa->nome_razao_social];
        })->sortBy('nome_razao_social')->pluck('nome_razao_social', 'id');
        $centrosCustos = CentroCusto::orderBy('nome', 'asc')->pluck('nome', 'id');
        $tiposVeiculos = TipoVeiculo::orderBy('nome', 'asc')->pluck('nome', 'id');
        return view('veiculos.create', compact('frotas', 'empresas', 'centrosCustos', 'tiposVeiculos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\VeiculoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VeiculoRequest $request)
    {
        Veiculo::create($request->all());
        return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Veiculo $veiculo
     * @return \Illuminate\Http\Response
     */
    public function show(Veiculo $veiculo)
    {
        return view('veiculos.show', compact('veiculo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Veiculo $veiculo)
    {
        $frotas = Frota::orderBy('nome', 'asc')->pluck('nome', 'id');
        $empresas = Empresa::get()->map(function ($empresa) {
            return ['id' => $empresa->id, 'nome_razao_social' => $empresa->pessoa->nome_razao_social];
        })->sortBy('nome_razao_social')->pluck('nome_razao_social', 'id');
        $centrosCustos = CentroCusto::orderBy('nome', 'asc')->pluck('nome', 'id');
        $tiposVeiculos = TipoVeiculo::orderBy('nome', 'asc')->pluck('nome', 'id');
        return view('veiculos.edit', compact('veiculo', 'frotas', 'empresas', 'centrosCustos', 'tiposVeiculos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VeiculoRequest $request, Veiculo $veiculo)
    {
        $veiculo->update($request->all());
        return redirect()->route('veiculos.index')->with('success', 'Veículo alterado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Veiculo $veiculo)
    {
        try {
            $veiculo->delete();
            return redirect()->route('veiculos.index')->with('success', 'Cadastro de Veículo excluído com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('veiculos.index')->with('danger', 'Não é possível excluir Veículo. Há vínculos');
        }
    }
}
