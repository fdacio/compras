<?php

namespace App\Http\Controllers;

use App\Http\Requests\CentroCustoRequest;
use App\CentroCusto;
use Exception;

class CentrosCustosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $centrosCustos = CentroCusto::orderBy('nome', 'asc');
        $nome = request()->get('nome');
        if (!empty($nome)) {
            $centrosCustos =  $centrosCustos->where('nome', 'LIKE', '%' . $nome . '%');
        }
        $centrosCustos = $centrosCustos->paginate(10);
        return view('centros-custos.index', compact('centrosCustos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('centros-custos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CentroCustoRequest $request)
    {
        CentroCusto::create($request->all());
        return redirect()->route('centros-custos.index')->with('success', 'Centro de Custo cadastrado com sucesso.');

    }

    /**
     * Display the specified resource.
     *
     * @param  CentroCusto $centroCusto
     * @return \Illuminate\Http\Response
     */
    public function show(CentroCusto $centroCusto)
    {
        return view('centros-custos.show', compact('centroCusto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CentroCusto $centroCusto)
    {
        return view('centros-custos.edit', compact('centroCusto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  CentroCusto $centroCusto
     * @return \Illuminate\Http\Response
     */
    public function update(CentroCustoRequest $request, CentroCusto $centroCusto)
    {
        $centroCusto->update($request->all());
        return redirect()->route('centros-custos.index')->with('success', 'Cadastro de Centro de Custo alterado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CentroCusto $centroCusto
     * @return \Illuminate\Http\Response
     */
    public function destroy(CentroCusto $centroCusto)
    {
        try {
            $centroCusto->delete();
            return redirect()->route('centros-custos.index')->with('success', 'Cadastro de Centro de Custo excluído com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('centros-custos.index')->with('danger', 'Não é possível excluir Centro de Custo. Há vínculos');
        }
    }
}
