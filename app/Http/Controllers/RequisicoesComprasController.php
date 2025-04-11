<?php

namespace App\Http\Controllers;

use App\CentroCusto;
use App\Http\Requests\RequisicaoCompraItemRequest;
use App\Http\Requests\RequisicaoCompraRequest;
use App\Produto;
use App\RequisicaoCompra;
use App\Solicitante;
use App\Veiculo;
use App\Reports\DemoRequisicaoCompraPdf;
use App\RequisicaoCompraItem;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class RequisicoesComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requisicoes = RequisicaoCompra::orderBy('id', 'desc');
        $requisitante = request()->get('id_requisitante');
        $solicitante = request()->get('id_solicitante');
        $veiculo = request()->get('id_veiculo');

        if (!empty($requisitante)) {
            $requisicoes =  $requisicoes->where('id_requisitante', $requisitante);
        }
        if (!empty($solicitante)) {
            $requisicoes =  $requisicoes->where('id_solicitante', $solicitante);
        }
        if (!empty($veiculo)) {
            $requisicoes =  $requisicoes->where('id_veiculo', $veiculo);
        }

        $requisitantes = CentroCusto::orderBy('nome', 'asc')->pluck('nome', 'id');
        $solicitantes = Solicitante::orderBy('nome', 'asc')->pluck('nome', 'id');
        $veiculos = Veiculo::get()->map(function($veiculo) {
            return ['id' => $veiculo->id, 'descricao' => 'Placa: ' . $veiculo->placa . ' - ' . $veiculo->marca . ' - ' . $veiculo->modelo];
        })->sortBy('descricao')->pluck('descricao', 'id');

        $requisicoes = $requisicoes->paginate(10);

        return view('requisicoes-compras.index', compact('requisicoes', 'requisitantes', 'solicitantes', 'veiculos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $requisitantes = CentroCusto::orderBy('nome', 'asc')->pluck('nome', 'id');

        $solicitantes = Solicitante::orderBy('nome', 'asc')->pluck('nome', 'id');

        $veiculos = Veiculo::get()->map(function($veiculo) {
            return ['id' => $veiculo->id, 'descricao' => 'Placa: ' . $veiculo->placa . ' - ' . $veiculo->marca . ' - ' . $veiculo->modelo];
        })->sortBy('descricao')->pluck('descricao', 'id');

        $tipos = collect(RequisicaoCompra::TIPOS)->map(function($tipo) {
            return ['tipo' => $tipo['value'], 'descricao' => $tipo['label']];
        })->pluck('descricao', 'tipo');

        return view('requisicoes-compras.create', compact('requisitantes', 'solicitantes', 'veiculos', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequisicaoCompraRequest $request)
    {
        $dados = $request->all();
        $hoje = Carbon::now();
        $dados = array_merge($dados, 
            [
                'data' => $hoje,
                'id_usuario_cadastrou' => auth()->user()->id,
                'id_usuario_alterou' => auth()->user()->id,
            ]);
        $requisicao = RequisicaoCompra::create($dados);
        return redirect()->route('requisicoes-compras.edit', $requisicao->id)->with('success', 'Requisição de Compras cadastrado com sucesso.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RequisicaoCompra $requisicao)
    {
        return view('requisicoes-compras.show', compact('requisicao'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(RequisicaoCompra $requisicao)
    {
        $requisitantes = CentroCusto::orderBy('nome', 'asc')->pluck('nome', 'id');

        $solicitantes = Solicitante::orderBy('nome', 'asc')->pluck('nome', 'id');

        $veiculos = Veiculo::get()->map(function($veiculo) {
            return ['id' => $veiculo->id, 'descricao' => 'Placa: ' . $veiculo->placa . ' - ' . $veiculo->marca . ' - ' . $veiculo->modelo];
        })->sortBy('descricao')->pluck('descricao', 'id');

        $tipos = collect(RequisicaoCompra::TIPOS)->map(function($tipo) {
            return ['tipo' => $tipo['value'], 'descricao' => $tipo['label']];
        })->pluck('descricao', 'tipo');

        return view('requisicoes-compras.edit', compact('requisicao', 'requisitantes', 'solicitantes', 'veiculos', 'tipos'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequisicaoCompraRequest $request, RequisicaoCompra $requisicao)
    {
        $requisicao->update($request->all());
        $requisicao->id_usuario_alterou = auth()->user()->id;
        return redirect()->route('requisicoes-compras.edit', $requisicao->id)->with('success', 'Requisição de Compras atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequisicaoCompra $requisicao)
    {
        try {
            $requisicao->delete();
            return redirect()->route('requisicoes-compras.index')->with('success', 'Cadastro de Requisição de Compra excluído oom sucesso.');
        } catch (Exception $e) {
            return redirect()->route('requisicoes-compras.index')->with('danger', 'Não é possível excluir Requisição de Compra. Há vínculos com outros registros.');
        }
    }


    public function itemCreate(RequisicaoCompra $requisicao) 
    {
        $itens = [];
        $produtos = Produto::get()->map(function($produto) {
            return ['id' => $produto->id, 'nome' => $produto->nome . ' - ' . $produto->unidade->nome];
        })->sortBy('nome')->pluck('nome', 'id');
        return view('requisicoes-compras.create-item', compact('requisicao', 'produtos', 'itens'));
    } 

    public function itemStore(RequisicaoCompra $requisicao, RequisicaoCompraItemRequest $request) 
    {
        $item = 1;
        $descricao = "";
        $unidade = "";
        $quantidade_solicitada = 0;
        $quantidade_a_cotar = 0;

        if ($requisicao->tipo == 'PRODUTO') {
            $produto = Produto::find($request->id_produto);
            $descricao = $produto->nome;
            $unidade = $produto->unidade->nome;
            $quantidade_solicitada = $request->quantidade_solicitada;
            $quantidade_a_cotar = $request->quantidade_a_cotar;
            $item = $requisicao->itens()->count() + 1;

        }

        if ($requisicao->tipo == 'SERVICO') {
            $descricao = $request->servico;
            $unidade = "UNIDADE";
            $quantidade_solicitada = $request->quantidade_solicitada;
            $quantidade_a_cotar = $request->quantidade_a_cotar;
            $item = $requisicao->itens()->count() + 1;
        }

        $dados = [
            'id_requisicao' => $requisicao->id,
            'item' => $item,
            'descricao' => $descricao,
            'unidade' => $unidade,
            'quantidade_solicitada' => $quantidade_solicitada,
            'quantidade_a_cotar' => $quantidade_a_cotar,
        ];

        RequisicaoCompraItem::create($dados);
        return redirect()->route('requisicoes-compras.item.create', $requisicao->id)->with('success', 'Item da Requisição de Compra cadastrado com sucesso.');

    }

    public function destroyItem(Request $request, RequisicaoCompra $requisicao)
    {
        $item = RequisicaoCompraItem::find($request->id_requisicao_compra_item);
        $item->delete();
        return redirect()->route('requisicoes-compras.item.create', $requisicao->id)->with('success', 'Item deletado!');
    }

    public function geraPdf(RequisicaoCompra $requisicao) 
    {
        $demo = new DemoRequisicaoCompraPdf('Requisição de Compra');
        $demo->setContent($requisicao);
        $demo->download();
    }

    public function autorizar(RequisicaoCompra $requisicao)
    {
        $requisicao->situacao = RequisicaoCompra::SITUACAO_AUTORIZADO;
        $requisicao->id_usuario_autorizacao = auth()->user()->id;
        $requisicao->data_autorizacao = Carbon::now();
        $requisicao->save();
        return redirect()->route('requisicoes-compras.index')->with('success', 'Requisição de Compra autorizada com sucesso.');
    }

}
