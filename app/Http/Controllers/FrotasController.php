<?php

namespace App\Http\Controllers;

use App\Http\Requests\FrotaRequest;
use App\Frota;
use Exception;

class FrotasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $frotas = Frota::orderBy('nome', 'asc');
        $nome = request()->get('nome');
        if (!empty($nome)) {
            $frotas =  $frotas->where('nome', 'LIKE', '%' . $nome . '%');
        }
        $frotas = $frotas->paginate(10);
        return view('frotas.index', compact('frotas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frotas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FrotaRequest $request)
    {
        Frota::create($request->all());
        return redirect()->route('frotas.index')->with('success', 'Frota cadastrado com sucesso.');

    }

    /**
     * Display the specified resource.
     *
     * @param  CentroCusto $centroCusto
     * @return \Illuminate\Http\Response
     */
    public function show(Frota $frota)
    {
        return view('frotas.show', compact('frota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Frota $frota)
    {
        return view('frotas.edit', compact('frota'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Frota  $frota
     * @return \Illuminate\Http\Response
     */
    public function update(FrotaRequest $request, Frota $frota)
    {
        $frota->update($request->all());
        return redirect()->route('frotas.index')->with('success', 'Cadastro de Frota alterado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Frota $frota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Frota $frota)
    {
        try {
            $frota->delete();
            return redirect()->route('frotas.index')->with('success', 'Cadastro de Frota excluído com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('frotas.index')->with('danger', 'Não é possível excluir Frota. Há vínculos');
        }
    }
}
