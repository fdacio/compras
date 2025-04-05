<?php

namespace App\Http\Controllers;

use App\AutorizacaoPagamento;
use App\AutorizacaoPagamentoDocumento;
use App\AutorizacaoPagamentoItem;
use App\CentroCusto;
use App\FormaPagamento;
use App\Http\Requests\AutorizacaoPagamentoDocumentoRequest;
use App\Http\Requests\AutorizacaoPagamentoItemRequest;
use App\Http\Requests\AutorizacaoPagamentoRequest;
use App\Pessoa;
use App\Produto;
use App\Reports\DemoAutorizacaoPagamentoPdf;
use App\Veiculo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AutorizacoesPagamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $autorizacoes = AutorizacaoPagamento::orderBy('id', 'desc');
        $favorecido = request()->get('id_favorecido');
        $veiculo = request()->get('id_veiculo');
        $cnpjCpf = request()->get('cnpj_cpf');
        $razaoSocialNome = request()->get('razao_social_nome');
        $pessoa = request()->get('pessoa');

        if (!empty($favorecido)) {
            $autorizacoes =  $autorizacoes->where('id_favorecido', $favorecido);
        }
        if (!empty($veiculo)) {
            $autorizacoes =  $autorizacoes->where('id_veiculo', $veiculo);
        }
        if (!empty($cnpjCpf)) {
            $cnpjCpf = str_replace(['.', '-', '/'], '', $cnpjCpf);
            $autorizacoes = $autorizacoes->whereHas('favorecido', function ($query) use ($cnpjCpf, $pessoa) {
                if ($pessoa == Pessoa::TIPO_PESSOA_FISICA) {
                    $query = $query->whereHas('pessoa', function ($query) use ($cnpjCpf) {
                        $query = $query->whereHas('pessoaFisica', function ($query) use ($cnpjCpf) {
                            $query = $query->where('cpf', $cnpjCpf);
                        });
                    });
                }
                if ($pessoa == Pessoa::TIPO_PESSOA_JURIDICA) {
                    $query = $query->whereHas('pessoa', function ($query) use ($cnpjCpf) {
                        $query = $query->whereHas('pessoaJuridica', function ($query) use ($cnpjCpf) {
                            $query = $query->where('cnpj', $cnpjCpf);
                        });
                    });
                }
            });
        }
        if (!empty($razaoSocialNome)) {
            $autorizacoes = $autorizacoes->whereHas('favorecido', function ($query) use ($razaoSocialNome, $pessoa) {
                if ($pessoa == Pessoa::TIPO_PESSOA_FISICA) {
                    $query = $query->whereHas('pessoa', function ($query) use ($razaoSocialNome) {
                        $query = $query->whereHas('pessoaFisica', function ($query) use ($razaoSocialNome) {
                            $query = $query->where('nome', 'like', '%' . $razaoSocialNome . '%');
                        });
                    });
                }
                if ($pessoa == Pessoa::TIPO_PESSOA_JURIDICA) {
                    $query = $query->whereHas('pessoa', function ($query) use ($razaoSocialNome) {
                        $query = $query->whereHas('pessoaJuridica', function ($query) use ($razaoSocialNome) {
                            $query = $query->where('razao_social', 'like', '%' . $razaoSocialNome . '%');
                        });
                    });
                }
            });
        }

        $veiculos = Veiculo::get()->map(function($veiculo) {
            return ['id' => $veiculo->id, 'descricao' => 'Placa: ' . $veiculo->placa . ' - ' . $veiculo->marca . ' - ' . $veiculo->modelo];
        })->sortBy('descricao')->pluck('descricao', 'id');

        $autorizacoes = $autorizacoes->paginate(10);

        return view('autorizacoes-pagamentos.index', compact('autorizacoes', 'veiculos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $favorecidos = [];
        $centrosCusto = CentroCusto::orderBy('nome', 'asc')->pluck('nome', 'id');
        $formasPagamentos = FormaPagamento::pluck('nome', 'id');
        return view('autorizacoes-pagamentos.create', compact('favorecidos', 'centrosCusto', 'formasPagamentos'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AutorizacaoPagamentoRequest $request)
    {
        $dados = $request->all();
        $hoje = Carbon::now();
        $dados = array_merge($dados, ['data' => $hoje, 'situacao' => AutorizacaoPagamento::SITUACAO_PENDENTE]);
        $autorizacao = AutorizacaoPagamento::create($dados);
        return redirect()->route('autorizacoes-pagamentos.edit', $autorizacao->id)->with('success', 'Autorização de Pagamento cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AutorizacaoPagamento $autorizacao)
    {
        return view('autorizacoes-pagamentos.show', compact('autorizacao'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AutorizacaoPagamento $autorizacao)
    {
        $favorecidos = [];
        $centrosCusto = CentroCusto::orderBy('nome', 'asc')->pluck('nome', 'id');
        $formasPagamentos = FormaPagamento::pluck('nome', 'id');
        return view('autorizacoes-pagamentos.edit', compact('favorecidos', 'centrosCusto', 'formasPagamentos', 'autorizacao'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AutorizacaoPagamentoRequest $request, AutorizacaoPagamento $autorizacao)
    {
        $autorizacao->update($request->all());
        return redirect()->route('autorizacoes-pagamentos.edit', $autorizacao->id)->with('success', 'Atualização de Pagamento atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AutorizacaoPagamento $autorizacao)
    {
        try {
            $autorizacao->delete();
            return redirect()->route('autorizacoes-pagamentos.index')->with('success', 'Atualização de Pagamento de Compra excluído oom sucesso.');
        } catch (Exception $e) {
            return redirect()->route('autorizacoes-pagamentos.index')->with('danger', 'Não é possível excluir Atualização de Pagamento. Há vínculos com outros registros.');
        }

    }

    public function itemCreate(AutorizacaoPagamento $autorizacao)
    {
        $itens = [];
        $produtos = Produto::get()->map(function($produto) {
            return ['id' => $produto->id, 'nome' => $produto->nome . ' - ' . $produto->unidade->nome];
        })->sortBy('nome')->pluck('nome', 'id');
        $veiculos = Veiculo::get()->map(function($veiculo) {
            return ['id' => $veiculo->id, 'descricao' => 'Placa: ' . $veiculo->placa . ' - ' . $veiculo->marca . ' - ' . $veiculo->modelo];
        })->sortBy('descricao')->pluck('descricao', 'id');
        return view('autorizacoes-pagamentos.create-item', compact('autorizacao', 'produtos', 'itens', 'veiculos'));
    }

    public function itemStore(AutorizacaoPagamento $autorizacao, AutorizacaoPagamentoItemRequest $request)
    {
        $item = $autorizacao->itens()->count() + 1;
        $descricao = $request->descricao;
        $unidade = 'UNIDADE';
        $quantidade = 1;
        $dados = [
            'id_autorizacao' => $autorizacao->id,
            'item' => $item,
            'descricao' => $descricao,
            'unidade' => $unidade,
            'quantidade' => $quantidade,
        ];

        if ($request->has('id_veiculo')) {
            $idVeiculo = $request->id_veiculo;
            $dados = array_merge($dados, ['id_veiculo' => $idVeiculo]);
        }
        if ($request->has('id_produto')) {
            $idProduto = $request->id_produto;
            $dados = array_merge($dados, ['id_produto' => $idProduto]);
        }        

        AutorizacaoPagamentoItem::create($dados);
        return redirect()->route('autorizacoes-pagamentos.item.create', $autorizacao->id)->with('success', 'Item da Autorização de Pagamento cadastrado com sucesso.');

    }

    public function destroyItem(Request $request, AutorizacaoPagamento $autorizacao)
    {
        $item = AutorizacaoPagamentoItem::find($request->id_autorizacao_pagamento_item);
        $item->delete();
        return redirect()->route('autorizacoes-pagamentos.item.create', $autorizacao->id)->with('success', 'Item deletado!');
    }

    public function documentoCreate(AutorizacaoPagamento $autorizacao)
    {
        return view('autorizacoes-pagamentos.documentos.create', compact('autorizacao'));
    }

    public function documentoUpload(AutorizacaoPagamentoDocumentoRequest $request, AutorizacaoPagamento $autorizacao)
    {
        $dados = [
            'id_autorizacao' => $autorizacao->id,
            'nome' => $request->get('nome')
        ];
        if (!empty($request->file('file-documento'))) {
            $directory = storage_path('app/');
            $dados['arquivo'] = $directory . $request->file('file-documento')->store('autoricacoes-pagamentos');
        }
        AutorizacaoPagamentoDocumento::create($dados);
        return redirect()->route('autorizacoes-pagamentos.edit', $autorizacao->id)->with('success', 'Documento enviado com sucesso.');
    }
    
    public function documentoDownload(AutorizacaoPagamentoDocumento $documento)
    {
        if (File::exists($documento->arquivo)) {                    
            return response()->download($documento->arquivo);
        }
        abort(404);
    }
    
    public function documentoDelete(AutorizacaoPagamentoDocumento $documento)
    {
        $idAutorizacao = $documento->id_autorizacao;
        $autorizacao = AutorizacaoPagamento::find($idAutorizacao);
        $documento->delete();
        return redirect()->route('autorizacoes-pagamentos.edit', $autorizacao->id)->with('success', 'Documento excluído com sucesso.');
    }

    public function geraPdf(AutorizacaoPagamento $autorizacao) 
    {
        $demo = new DemoAutorizacaoPagamentoPdf('Autorização de Pagamento');
        $demo->setContent($autorizacao);
        $demo->download();
    }
}
