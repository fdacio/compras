<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitanteRequest;
use App\Solicitante;
use Exception;

class SolicitantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solicitantes = Solicitante::orderBy('nome', 'asc');
        $nome = request()->get('nome');
        if (!empty($nome)) {
            $solicitantes =  $solicitantes->where('nome', 'LIKE', '%' . $nome . '%');
        }
        $solicitantes = $solicitantes->paginate(10);
        return view('solicitantes.index', compact('solicitantes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('solicitantes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolicitanteRequest $request)
    {
        Solicitante::create($request->all());
        return redirect()->route('solicitantes.index')->with('success', 'Solicitante cadastrado com sucesso.');

    }

    /**
     * Display the specified resource.
     *
     * @param  CentroCusto $centroCusto
     * @return \Illuminate\Http\Response
     */
    public function show(Solicitante $solicitante)
    {
        return view('solicitantes.show', compact('solicitante'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Solicitante $solicitante)
    {
        return view('solicitantes.edit', compact('solicitante'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Solicitante  $solicitante
     * @return \Illuminate\Http\Response
     */
    public function update(SolicitanteRequest $request, Solicitante $solicitante)
    {
        $solicitante->update($request->all());
        return redirect()->route('solicitantes.index')->with('success', 'Cadastro de Solicitante alterado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Solicitante $solicitante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Solicitante $solicitante)
    {
        try {
            $solicitante->delete();
            return redirect()->route('solicitantes.index')->with('success', 'Cadastro de Solicitante excluído com sucesso.');
        } catch (Exception $e) {
            return redirect()->route('solicitantes.index')->with('danger', 'Não é possível excluir Solicitante. Há vínculos');
        }
    }
}
