<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Uf;
use Illuminate\Support\Facades\Response;

class CidadesController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function __invoke(Uf $uf)
    {
        $cidades = $uf->cidades()->get();
        return Response::json($cidades, 200);
    }
}
