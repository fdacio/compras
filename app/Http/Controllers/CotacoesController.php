<?php

namespace App\Http\Controllers;

use App\Cotacao;
use App\CotacaoFornecedor;
use App\CotacaoFornecedorItem;
use App\CotacaoFornecedorVencedor;
use App\Fornecedor;
use App\Http\Requests\CotacaoFornecedoItemRequest;
use App\Reports\DemoCotacaoPdf;
use App\RequisicaoCompra;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CotacoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cotacoes = Cotacao::orderBy('data', 'desc');

        $numereCotacao = request()->get('numero_cotacao');
        if ($numereCotacao) {
            $cotacoes = $cotacoes->where('id', $numereCotacao);
        };
        $numeroRequisicao = request()->get('numero_requisicao');
        if ($numeroRequisicao) {
            $cotacoes = $cotacoes->where('id_requisicao', $numeroRequisicao);
        };

        $cotacoes = $cotacoes->paginate(10);
        return view('cotacoes.index', compact('cotacoes'));
    }

    /**
     * Display the specified resource.
     *
     * @param  CentroCusto $centroCusto
     * @return \Illuminate\Http\Response
     */
    public function show(Cotacao $cotacao)
    {
        return view('cotacoes.show', compact('cotacao'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cotacao $cotacao)
    {
        if ($cotacao->finalizada) {
            return redirect()->back()->with('danger', 'Não é possível editar uma Cotação já finalizada.');
        }
        $fornecedores = Fornecedor::get()->map(function ($fornecedor) {
            return ['id' => $fornecedor->id, 'nome_razao_social' => $fornecedor->pessoa->nome_razao_social];
        })->sortBy('nome_razao_social')->pluck('nome_razao_social', 'id');

        return view('cotacoes.edit', compact('cotacao', 'fornecedores'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cotacao $cotacao)
    {
        try {
            DB::beginTransaction();
            $cotacao->requisicao->update(['situacao' => RequisicaoCompra::SITUACAO_PENDENTE]);
            CotacaoFornecedorItem::whereIn('id_cotacao_fornecedor', $cotacao->fornecedores->pluck('id'))->delete();
            CotacaoFornecedor::where('id_cotacao', $cotacao->id)->delete();
            Cotacao::destroy($cotacao->id);
            DB::commit();
            return redirect()->route('cotacoes.index')->with('success', 'Cadastro de Cotação excluído oom sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('cotacoes.index')->with('danger', 'Não é possível excluir Cotação. Há vínculos com outros registros.');
        }
    }

    /**
     * Store a fornecedor newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFornecedor(Request $request, Cotacao $cotacao)
    {
        $idFornecedor = $request->id_fornecedor;
        $idCotacao = $cotacao->id;
        $request->validate([
            'id_fornecedor' => [
                'required',
                Rule::unique('cotacoes_fornecedores')->where(function ($query) use ($idCotacao, $idFornecedor) {
                    return $query->where('id_cotacao', $idCotacao)->where('id_fornecedor', $idFornecedor);
                })
            ],
        ], [
            'id_fornecedor.required' => 'O campo Fornecedor é obrigatório.',
            'id_fornecedor.exists' => 'Fornecedor não encontrado.',
            'id_fornecedor.unique' => 'Fornecedor já informado.',
        ]);

        $cotacaoFornecedor = CotacaoFornecedor::create([
            'id_cotacao' => $cotacao->id,
            'id_fornecedor' => $request->id_fornecedor,
            'id_usuario_cadastrou' => auth()->user()->id,
        ]);

        foreach ($cotacao->requisicao->itens as $item) {
            $dados = [
                'id_cotacao_fornecedor' =>  $cotacaoFornecedor->id,
                'item' => $item->item,
                'descricao' => $item->descricao,
                'unidade' => $item->unidade,
                'quantidade_solicitada' => $item->quantidade_solicitada,
                'quantidade_cotada' => $item->quantidade_solicitada,
                'quantidade_atendida' => $item->quantidade_solicitada,
            ];
            CotacaoFornecedorItem::create($dados);
        }

        return redirect()->route('cotacoes.edit', $cotacao->id)->with('success', 'Fornecedor da Cotação cadastrado com sucesso.');
    }

    /**
     * Remove the specified resource fornecedor from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyFornecedor(Request $request, Cotacao $cotacao)
    {
        try {
            DB::beginTransaction();
            CotacaoFornecedorItem::where('id_cotacao_fornecedor', $request->id_cotacao_fornecedor)->delete();
            $cotacaoFornecedor = CotacaoFornecedor::find($request->id_cotacao_fornecedor);
            $cotacaoFornecedor->delete();
            DB::commit();
            return redirect()->route('cotacoes.edit', $cotacao->id)->with('success', 'Fornecedor da Cotação excluído com sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('cotacoes.edit', $cotacao->id)->with('danger', 'Não é possível excluir Fornecedor da Cotação. Há vínculos com outros registros.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Cotacao  $cotacao    
     * @return \Illuminate\Http\Response
     */
    public function update(CotacaoFornecedoItemRequest $request, Cotacao $cotacao)
    {
        $quantidadesCotadas = $request->quantidade_cotada;
        $quantidadesAtendidas = $request->quantidade_atendida;
        $valoresUnitarios = $request->valor_unitario;

        try {
            DB::beginTransaction();
            foreach ($quantidadesCotadas as $key => $value) {
                $valorUnitario = $valoresUnitarios[$key];
                $quantidadeCotada = $quantidadesCotadas[$key];
                $quantidadeAtendida = $quantidadesAtendidas[$key];

                CotacaoFornecedorItem::where('id', $key)->update([
                    'quantidade_cotada' => $quantidadeCotada,
                    'quantidade_atendida' => $quantidadeAtendida,
                    'valor_unitario' => $valorUnitario,
                    'valor_total' => $quantidadeAtendida * $valorUnitario,
                ]);
            }
            DB::commit();
            return redirect()->route('cotacoes.edit', $cotacao->id)->with('success', 'Valores do fornecedor informados com sucesso.');
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return redirect()->route('cotacoes.edit', $cotacao->id)->with('danger', 'Não foi possível atualizar os valores do fornecedor.');
        }
    }

    /**
     * Finally the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Cotacao  $cotacao    
     * @return \Illuminate\Http\Response
     */
    public function finalizar(Cotacao $cotacao)
    {
        if ($cotacao->finalizada) {
            return redirect()->back()->with('danger', 'Cotação já finalizada.');
        }

        if ($cotacao->fornecedores->count() == 0) {
            return redirect()->back()->with('danger', 'Não é possível finalizar Cotação sem Fornecedor.');
        }

        if ($cotacao->fornecedores->count() < 2) {
            return redirect()->back()->with('danger', 'Não é possível finalizar Cotação com menos de 2 Fornecedores.');
        }

        $fornecedores = $cotacao->fornecedores;
        foreach ($fornecedores as $fornecedor) {
            $itens = $fornecedor->itens;
            foreach ($itens as $item) {
                if ($item->quantidade_cotada == 0 || $item->quantidade_atendida == 0 || $item->valor_unitario == 0) {
                    return redirect()->back()->with('danger', 'Não é possível finalizar Cotação com valores zerados.');
                }
            }
        }

        try {
            DB::beginTransaction();
            $cotacao->update(['finalizada' => 1]);
            $this->geraFornecedorVencedor($cotacao);
            $cotacao->requisicao->update(['situacao' => RequisicaoCompra::SITUACAO_COTADA]);
            DB::commit();
            return redirect()->route('cotacoes.show', $cotacao->id)->with('success', 'Cotação finalizada com sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->route('cotacoes.index')->with('danger', 'Não foi possível finalizar a Cotação.');
        }
    }

    private function geraFornecedorVencedor(Cotacao $cotacao)
    {
        $fornecedores = $cotacao->fornecedores;
        $menorValor = null;
        $listaFornecedoresCandidatos = [];
        foreach ($fornecedores as $fornecedor) {
            $valorTotal = 0;
            foreach ($fornecedor->itens as $item) {
                $valorTotal += $item->valor_total;
            }
            $listaFornecedoresCandidatos[] = [
                'id_fornecedor' => $fornecedor->id_fornecedor,
                'valor_total' => $valorTotal,
            ];
        }

        $menorValor = collect($listaFornecedoresCandidatos)->sortBy('valor_total')->first();
        $vencedores = [];
        foreach ($listaFornecedoresCandidatos as $key => $fornecedorCandidato) {
            if ($fornecedorCandidato['valor_total'] == $menorValor['valor_total']) {
                $vencedores[] = [
                    'id_fornecedor' => $fornecedorCandidato['id_fornecedor'],
                    'valor_total' => $fornecedorCandidato['valor_total'],
                ];
            }
        
        }
        foreach ($vencedores as $key => $vencedor) {
            $fornecedor = $vencedor['id_fornecedor'];
            CotacaoFornecedorVencedor::updateOrCreate([
                'id_cotacao' => $cotacao->id,
                'id_fornecedor' => $fornecedor,
            ]);
        }
    }

    public function geraPdf(Cotacao $cotacao)
    {
        $demo = new DemoCotacaoPdf('Cotação');
        $demo->setContent($cotacao);
        $demo->download();
    }
}
