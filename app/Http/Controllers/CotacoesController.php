<?php

namespace App\Http\Controllers;

use App\Cotacao;
use Illuminate\Http\Request;

class CotacoesController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Aqui você pode adicionar a lógica para buscar as cotações
        // e retornar a view com os dados necessários.
        $cotacoes = Cotacao::orderBy('data', 'desc');
        $cotacoes = $cotacoes->paginate(10);
        return view('cotacoes.index', compact('cotacoes')); 
    }

    public function edit(Cotacao $cotacao)
    {
        // Aqui você pode adicionar a lógica para editar uma cotação específica
        return view('cotacoes.edit', compact('cotacao'));
    }
}
