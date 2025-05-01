<?php

namespace App\Http\Controllers;

use App\Cotacao;
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

    public function edit(Cotacao $cotacao)
    {
        // Aqui você pode adicionar a lógica para editar uma cotação específica
        return view('cotacoes.edit', compact('cotacao'));
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
}
