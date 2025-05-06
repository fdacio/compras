@extends('layouts.app')
@section('title', 'Requisições de Compras - Visualizar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Visualizar Autorização de Pagamento</h2>
        </div>
        <div class="card-body">
            <!-- Tabs Links-->
            <ul class="nav nav-tabs mb-2" id="tabs-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tabs-cabecalho-tab" data-toggle="pill" href="#tabs-cabecalho" role="tab"
                        aria-controls="tabs-cabecalho" aria-selected="true">Cabeçalho</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tabs-itens-tab" data-toggle="pill" href="#tabs-itens" role="tab"
                        aria-controls="tabs-itens" aria-selected="false">Itens</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tabs-documentos-tab" data-toggle="pill" href="#tabs-documentos" role="tab"
                        aria-controls="tabs-documentos" aria-selected="false">Documentos</a>
                </li>
            </ul>
            <!-- Começo das tabs-->
            <div class="tab-content" id="tabs-tabContent">
                <!-- Tab Cabeçalho-->
                <div class="tab-pane fade show active" id="tabs-cabecalho" role="tabpanel"
                    aria-labelledby="tabs-cabecalho-tab">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th class="col-md-3">ID:</th>
                            <td>{{ $autorizacao->id }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Data:</th>
                            <td>{{ \Carbon\Carbon::parse($autorizacao->data)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Favorecido:</th>
                            <td>{{ Formatter::cpfCnpj($autorizacao->favorecido->pessoa->cpf_cnpj) . ' - ' . $autorizacao->favorecido->pessoa->nome_razao_social }}
                            </td>
                        </tr>
                        <tr>
                            <th>Contrato:</th>
                            <td>{{ $autorizacao->empresa->pessoa->nome_razao_social }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Centro de Custo:</th>
                            <td>{{ $autorizacao->centroCusto->nome }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Forma de Pagamento:</th>
                            <td>{{ $autorizacao->formaPagamento->nome }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Valor:</th>
                            <td>{{ 'R$ ' . number_format($autorizacao->valor, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Banco:</th>
                            <td>{{ $autorizacao->banco }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Agência:</th>
                            <td>{{ $autorizacao->agencia }}
                            </td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Conta:</th>
                            <td>{{ $autorizacao->conta }}
                            </td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Operação:</th>
                            <td>{{ $autorizacao->operacao }}
                            </td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Chave PIX:</th>
                            <td>{{ $autorizacao->chave_pix }}
                            </td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Situação:</th>
                            <td>{{ $autorizacao->situacao_nome }}</td>
                        </tr>
                        @if ($autorizacao->situacao == \App\AutorizacaoPagamento::SITUACAO_AUTORIZADO)
                            <tr>
                                <th class="col-md-3">Usuário Autorizador:</th>
                                <td>{{ $autorizacao->usuarioAutorizacao ? $autorizacao->usuarioAutorizacao->name : 'Usuário não cadastrado' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="col-md-3">Data da Autorização:</th>
                                <td>{{ $autorizacao->data_autorizacao ? \Carbon\Carbon::parse($autorizacao->data_autorizacao)->format('d/m/Y') : '' }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <th class="col-md-3">Observação:</th>
                            <td>
                                <p style="white-space: pre-wrap">{{ $autorizacao->observacao }}</p>
                            </td>
                        </tr>
                        <tr>
                            <th>Usuário que Cadastrou:</th>
                            <td>{{ $autorizacao->usuarioCadastrou ? $autorizacao->usuarioCadastrou->name : '' }}</td>
                        </tr>
                        <tr>
                            <th>Criado:</th>
                            <td>{{ \Carbon\Carbon::parse($autorizacao->created_at)->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Usuário que Alterou:</th>
                            <td>{{ $autorizacao->usuarioAlterou ? $autorizacao->usuarioAlterou->name : '' }}</td>
                        </tr>
                        <tr>
                            <th>Alterado:</th>
                            <td>{{ \Carbon\Carbon::parse($autorizacao->updated_at)->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <!-- Fim cabeçalho -->
                    </table>
                </div>
                <!-- Tab de Itens -->
                <div class="tab-pane fade" id="tabs-itens" role="tabpanel" aria-labelledby="tabs-itens-tab">
                    <div class="card">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <section class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th>Item</th>
                                        <th>Descrição</th>
                                        <th style="width: 45px;"></th>
                                    </thead>
                                    <tbody>
                                        @if ($autorizacao->itens->count() == 0)
                                            <tr>
                                                <th class="text-center" colspan="3">Nenhum item cadastrado</th>
                                            </tr>
                                        @else
                                            @foreach ($autorizacao->itens as $item)
                                                <tr>
                                                    <td>{{ $item->item }}</td>
                                                    <td>
                                                        <p style="white-space: pre-wrap">{{ $item->descricao }}</p>
                                                        @if ($item->veiculo)
                                                            <div>
                                                                <strong>Veículo:</strong>
                                                                {{ $item->veiculo->placa . '-' . $item->veiculo->marca . ' ' . $item->veiculo->modelo }}
                                                            </div>
                                                        @endif
                                                        @if ($item->produto)
                                                            <div>
                                                                <strong>Produto:</strong>
                                                                {{ $item->produto->nome . '-' . $item->produto->unidade->nome }}
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <td class="text-nowrap">
                                                        {!! Form::open([
                                                            'id' => 'form_excluir_' . $item->id,
                                                            'method' => 'delete',
                                                            'route' => ['autorizacoes-pagamentos.del-item.destroy', $autorizacao->id],
                                                            'style' => 'display: inline',
                                                        ]) !!}
                                                        {!! Form::hidden('id_autorizacao_pagamento_item', $item->id) !!}
                                                        {!! Form::button('<i class="fa fa-trash"></i>', [
                                                            'class' => 'btn btn-danger modal-excluir',
                                                            'style' => 'padding: 1px 6px;',
                                                        ]) !!}
                                                        {!! Form::close() !!}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </section>
                        </div>
                    </div>
                </div>
                <!-- Fim Tab de Itens -->
                <!-- Tab de Documentos -->
                <div class="tab-pane fade" id="tabs-documentos" role="tabpanel" aria-labelledby="tabs-documentos-tab">
                    <div class="card">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <section class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th>Nome</th>
                                        <th style="width: 45px;"></th>
                                    </thead>
                                    <tbody>
                                        @if ($autorizacao->documentos->count() == 0)
                                            <tr>
                                                <th class="text-center" colspan="3">Nenhum documento cadastrado</th>
                                            </tr>
                                        @else
                                            @foreach ($autorizacao->documentos as $documento)
                                                <tr>
                                                    <td>{{ $documento->nome }}</td>
                                                    <td class="text-nowrap">
                                                        <a href="{{ route('autorizacoes-pagamentos.documentos.download', $documento->id) }}"
                                                            target="_blank" class="btn btn-primary btn-sm"
                                                            title="Baixar documento">
                                                            <i class="fa fa-download text-white"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('autorizacoes-pagamentos.edit', $autorizacao->id) }}" class="btn btn-primary"
                title="Editar">Editar</a>
            <a href="{{ route('autorizacoes-pagamentos.gera.pdf', $autorizacao->id) }}" class="btn btn-success"
                title="download" target="_blank">Demonstrativo</a>
            <a class="btn btn-danger" href="{{ route('autorizacoes-pagamentos.index') }}">Voltar</a>
        </div>
    </div>
@endsection
