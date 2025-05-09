<?php

namespace App\Http\Controllers;

use App\CentroCusto;
use App\Cotacao;
use App\Empresa;
use App\Http\Requests\RequisicaoCompraItemRequest;
use App\Http\Requests\RequisicaoCompraRequest;
use App\Produto;
use App\RequisicaoCompra;
use App\Solicitante;
use App\Veiculo;
use App\Reports\DemoRequisicaoCompraPdf;
use App\RequisicaoCompraItem;
use App\TipoUsuario;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class RequisicoesComprasController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = User::findOrFail(auth()->user()->id);
            if ($user->tipo->id == TipoUsuario::NIVEL_OPERADOR) {
                return redirect()->route('home')->with('danger', 'Você não tem permissão para acessar esta área.');
            }
            return $next($request);
        });
    }

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
        $veiculos = Veiculo::get()->map(function ($veiculo) {
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
        $empresas = Empresa::get()->map(function ($empresa) {
            return ['id' => $empresa->id, 'nome_razao_social' => $empresa->pessoa->nome_razao_social];
        })->sortBy('nome_razao_social')->pluck('nome_razao_social', 'id');
        $veiculos = Veiculo::get()->map(function ($veiculo) {
            return ['id' => $veiculo->id, 'descricao' => 'Placa: ' . $veiculo->placa . ' - ' . $veiculo->marca . ' - ' . $veiculo->modelo];
        })->sortBy('descricao')->pluck('descricao', 'id');
        $tipos = collect(RequisicaoCompra::TIPOS)->map(function ($tipo) {
            return ['tipo' => $tipo['value'], 'descricao' => $tipo['label']];
        })->pluck('descricao', 'tipo');

        return view('requisicoes-compras.create', compact('requisitantes', 'solicitantes', 'empresas',   'veiculos', 'tipos'));
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
        $dados = array_merge(
            $dados,
            [
                'data' => $hoje,
                'id_usuario_cadastrou' => auth()->user()->id,
                'id_usuario_alterou' => auth()->user()->id,
            ]
        );
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
        if ($requisicao->situacao == RequisicaoCompra::SITUACAO_CANCELADA) {
            return redirect()->route('requisicoes-compras.index')->with('danger', 'Requisição cancelada. Não é possível editar.');
        }

        if ($requisicao->situacao == RequisicaoCompra::SITUACAO_AUTORIZADA) {
            return redirect()->route('requisicoes-compras.index')->with('danger', 'Requisição de Compra já autorizada. Não é possível editar.');
        }

        $requisitantes = CentroCusto::orderBy('nome', 'asc')->pluck('nome', 'id');
        $solicitantes = Solicitante::orderBy('nome', 'asc')->pluck('nome', 'id');
        $empresas = Empresa::get()->map(function ($empresa) {
            return ['id' => $empresa->id, 'nome_razao_social' => $empresa->pessoa->nome_razao_social];
        })->sortBy('nome_razao_social')->pluck('nome_razao_social', 'id');
        $veiculos = Veiculo::get()->map(function ($veiculo) {
            return ['id' => $veiculo->id, 'descricao' => 'Placa: ' . $veiculo->placa . ' - ' . $veiculo->marca . ' - ' . $veiculo->modelo];
        })->sortBy('descricao')->pluck('descricao', 'id');
        $tipos = collect(RequisicaoCompra::TIPOS)->map(function ($tipo) {
            return ['tipo' => $tipo['value'], 'descricao' => $tipo['label']];
        })->pluck('descricao', 'tipo');

        return view('requisicoes-compras.edit', compact('requisicao', 'requisitantes', 'solicitantes', 'empresas', 'veiculos', 'tipos'));
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
        $dados = $request->all();
        $dados = array_merge(
            $dados,
            [
                'id_usuario_alterou' => auth()->user()->id,
            ]
        );
        $requisicao->update($dados);
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

        if ($requisicao->situacao == RequisicaoCompra::SITUACAO_AUTORIZADA) {
            return redirect()->route('requisicoes-compras.index')->with('danger', 'Requisição de Compra já autorizada. Não é possível excluir.');
        }

        try {
            $requisicao->delete();
            return redirect()->route('requisicoes-compras.index')->with('success', 'Cadastro de Requisição de Compra excluído oom sucesso.');
        } catch (Exception $e) {
            return redirect()->route('requisicoes-compras.index')->with('danger', 'Não é possível excluir Requisição de Compra. Há vínculos com outros registros.');
        }
    }

    public function cancelar(RequisicaoCompra $requisicao)
    {
        if ($requisicao->situacao == RequisicaoCompra::SITUACAO_CANCELADA) {
            return redirect()->route('requisicoes-compras.index')->with('danger', 'Requisição já cancelada. ');
        }

        if ($requisicao->situacao == RequisicaoCompra::SITUACAO_AUTORIZADA) {
            return redirect()->route('requisicoes-compras.index')->with('danger', 'Requisição de Compra já autorizada. Não é possível cancelar.');
        }

        $requisicao->situacao = RequisicaoCompra::SITUACAO_CANCELADA;
        $requisicao->save();
        return redirect()->route('requisicoes-compras.index')->with('success', 'Cadastro de Requisição de Compra cancelado com sucesso.');
    }

    public function itemCreate(RequisicaoCompra $requisicao)
    {
        $itens = [];
        $produtos = Produto::get()->map(function ($produto) {
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

        if ($requisicao->tipo == 'PRODUTO') {
            $produto = Produto::find($request->id_produto);
            $descricao = $produto->nome;
            $unidade = $produto->unidade->nome;
            $quantidade_solicitada = $request->quantidade_solicitada;
        }

        if ($requisicao->tipo == 'SERVICO') {
            $descricao = $request->servico;
            $unidade = "UNIDADE";
            $quantidade_solicitada = $request->quantidade_solicitada;
        }

        $dados = [
            'id_requisicao' => $requisicao->id,
            'item' => $item,
            'descricao' => $descricao,
            'unidade' => $unidade,
            'quantidade_solicitada' => $quantidade_solicitada,
        ];

        RequisicaoCompraItem::create($dados);
        $this->updateNumeroItem($requisicao);
        return redirect()->route('requisicoes-compras.item.create', $requisicao->id)->with('success', 'Item da Requisição de Compra cadastrado com sucesso.');
    }

    public function destroyItem(Request $request, RequisicaoCompra $requisicao)
    {
        $item = RequisicaoCompraItem::find($request->id_requisicao_compra_item);
        $item->delete();
        $this->updateNumeroItem($requisicao);
        return redirect()->route('requisicoes-compras.item.create', $requisicao->id)->with('success', 'Item deletado!');
    }

    private function updateNumeroItem(RequisicaoCompra $requisicao)
    {
        $idx = 1;
        foreach($requisicao->itens()->get() as $item) {
            $item->update(['item' => $idx]);
            $idx++;
        }
    }


    public function geraPdf(RequisicaoCompra $requisicao)
    {
        $demo = new DemoRequisicaoCompraPdf('Requisição de Compra');
        $demo->setContent($requisicao);
        $demo->download();
    }

    public function cotar(RequisicaoCompra $requisicao)
    {
        $cotacao = Cotacao::where('id_requisicao', $requisicao->id)->first();
        if (!$cotacao) {
            $dados = [
                'situacao' => RequisicaoCompra::SITUACAO_EM_COTACAO,
            ];
            $requisicao->update($dados);
            $cotacao = new Cotacao();
            $cotacao->id_requisicao = $requisicao->id;
            $cotacao->id_usuario_cadastrou = auth()->user()->id;
            $cotacao->id_usuario_alterou = auth()->user()->id;
            $cotacao->data = Carbon::now();
            $cotacao->save();
            return redirect()->route('cotacoes.edit', $cotacao->id);
        }
        return redirect()->route('requisicoes-compras.index');

    }

    public function cotacaoEdit(RequisicaoCompra $requisicao)
    {
        $cotacao = Cotacao::where('id_requisicao', $requisicao->id)->first();
        if ($cotacao) {
            return redirect()->route('cotacoes.edit', $cotacao->id);
        }
        return redirect()->route('requisicoes-compras.index');
    }

    public function cotacaoShow(RequisicaoCompra $requisicao) 
    {
        $cotacao = Cotacao::where('id_requisicao', $requisicao->id)->first();
        if ($cotacao) {
            return redirect()->route('cotacoes.show', $cotacao->id);
        }
        return redirect()->route('requisicoes-compras.index');

    }

    /**
     * @return \Illuminate\Http\Response
     * Retorna as requisições de compras que estão com a situação "COTADA"
     * e que o usuário para o administração possa autorizar
     */
    public function cotadasAutorizacoes()
    {
        $requisicoes = RequisicaoCompra::whereIn('situacao', [
            RequisicaoCompra::SITUACAO_COTADA, 
            RequisicaoCompra::SITUACAO_AGUARDANDO_AUTORIZACAO,
            RequisicaoCompra::SITUACAO_AUTORIZADA])
           ->orderBy('id', 'desc');
        $requisicoes = $requisicoes->paginate(10);
        return view('requisicoes-compras.cotadas-autorizacoes', compact('requisicoes'));
    }

    public function autorizar(RequisicaoCompra $requisicao)
    {
        $user = User::findOrFail(auth()->user()->id);
        if ($user->tipo->id != TipoUsuario::NIVEL_ADMINISTRADOR) {
            return redirect()->route('home')->with('danger', 'Você não tem permissão ação.');
        }

        $requisicao->situacao = RequisicaoCompra::SITUACAO_AUTORIZADA;
        $requisicao->id_usuario_autorizacao = auth()->user()->id;
        $requisicao->data_autorizacao = Carbon::now();
        $requisicao->save();
        return redirect()->route('requisicoes-compras.index')->with('success', 'Requisição de Compra autorizada com sucesso.');
    }
}
