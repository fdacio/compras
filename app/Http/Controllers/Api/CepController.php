<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Canducci\Cep\Facades\Cep;

class CepController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getDados($cep)
    {
        $cepResponse = Cep::find($cep);
        $data = $cepResponse->getCepModel();
        return response()->json($data);
    }
}
