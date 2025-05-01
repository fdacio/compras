<?php

namespace App\Http\Controllers;

use App\Cotacao;
use App\CotacaoFornecedor;
use App\CotacaoFornecedorItem;
use App\Fornecedor;
use App\RequisicaoCompra;
use Exception;
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
            $cotacao->fornecedores()->itens()->delete();
            $cotacao->fornecedores()->delete();
            $cotacao->delete();
            $cotacao->requisicao()->update(['situacao' => RequisicaoCompra::SITUACAO_PENDENTE]);
            return redirect()->route('cotacoes.index')->with('success', 'Cadastro de Cotação excluído oom sucesso.');
        } catch (Exception $e) {
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
        $request->validate([
            'id_fornecedor' => 'required|unique:cotacoes_fornecedores,id_fornecedor',
        ],[
            'id_fornecedor.required' => 'O campo Fornecedor é obrigatório.',
            'id_fornecedor.exists' => 'Fornecedor não encontrado.', 
        ]);

        $cotacaoFornecedor = CotacaoFornecedor::create([
            'id_cotacao' => $cotacao->id,
            'id_fornecedor' => $request->id_fornecedor,
            'id_usuario_cadastrou' => auth()->user()->id,
        ]);
        dd($cotacao->requisicao());

        foreach ($cotacao->requisicao()->itens() as $item) {
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
        $cotacaoFornecedor = CotacaoFornecedor::find($request->id_cotacao_fornecedor);
        $cotacaoFornecedor->itens()->where('id_cotacao_fornecedor', $cotacaoFornecedor->id)->delete();
        $cotacaoFornecedor->delete();
        return redirect()->route('cotacoes.edit', $cotacao->id)->with('success', 'Fornecedor da Cotação excluído com sucesso.');
    }
}
