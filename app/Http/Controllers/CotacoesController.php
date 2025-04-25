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
        $cotacoes = Cotacao::orderBy('data', 'desc')->get();
        $cotacoes = $cotacoes->paginate(10);
        return view('cotacoes.index', compact('cotacoes')); 
    }
}
