<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UnidadeRequest;
use App\Unidade;
use Exception;

class UnidadesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnidadeRequest $request)
    {
        Unidade::create($request->all());
        $unidades = Unidade::orderBy('nome', 'ASC')->pluck('nome', 'id');
        return ['success' => true, 'message' => 'Registro salvo com sucesso.', 'dados' => $unidades];
    }
}
