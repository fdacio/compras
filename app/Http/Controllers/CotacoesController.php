<?php

namespace App\Http\Controllers;

use App\Cotacao;
use App\CotacaoFornecedor;
use App\CotacaoFornecedorItem;
use App\Fornecedor;
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
        // Aqui você pode adicionar a lógica para buscar as cotações
        // e retornar a view com os dados necessários.
        $cotacoes = Cotacao::orderBy('data', 'desc');
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
        return redirect()->route('cotacoes.index');
        //return view('cotacoes.show', compact('cotacao'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(Cotacao $cotacao)
    {
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
}
