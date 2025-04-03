<?php

namespace App\Http\Controllers;

use App\AutorizacaoPagamento;
use App\CentroCusto;
use App\Http\Requests\AutorizacaoPagamentoRequest;
use App\Pessoa;
use App\Veiculo;
use Carbon\Carbon;
use Cotacao\FormaPagamento;
use Exception;

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
        $municipios = CentroCusto::orderBy('nome', 'asc')->pluck('nome', 'id');
        $veiculos = Veiculo::get()->map(function($veiculo) {
            return ['id' => $veiculo->id, 'descricao' => 'Placa: ' . $veiculo->placa . ' - ' . $veiculo->marca . ' - ' . $veiculo->modelo];
        })->sortBy('descricao')->pluck('descricao', 'id');
        $formasPagamentos = FormaPagamento::pluck('nome', 'id');
        return view('autorizacoes-pagamentos.create', compact('favorecidos', 'municipios', 'veiculos', 'formasPagamentos'));

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
        $municipios = CentroCusto::orderBy('nome', 'asc')->pluck('nome', 'id');
        $veiculos = Veiculo::get()->map(function($veiculo) {
            return ['id' => $veiculo->id, 'descricao' => 'Placa: ' . $veiculo->placa . ' - ' . $veiculo->marca . ' - ' . $veiculo->modelo];
        })->sortBy('descricao')->pluck('descricao', 'id');
        $formasPagamentos = FormaPagamento::pluck('nome', 'id');
        return view('autorizacoes-pagamentos.edit', compact('favorecidos', 'municipios', 'veiculos', 'formasPagamentos', 'autorizacao'));
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
}
