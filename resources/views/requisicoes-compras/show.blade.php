@extends('layouts.app')
@section('title', 'Requisições de Compras - Visualizar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Visualizar Requisições de Compras</h2>
        </div>
        <div class="card-body">
            <!-- Tabs Links-->
            <ul class="nav nav-tabs mb-2" id="tabs-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tabs-cabecalho-tab" data-toggle="pill" href="#tabs-cabecalho" role="tab"
                        aria-controls="tabs-cabecalho" aria-selected="true">Requisição</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tabs-itens-tab" data-toggle="pill" href="#tabs-itens" role="tab"
                        aria-controls="tabs-itens" aria-selected="false">Itens</a>
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
                            <td>{{ $requisicao->id }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Data:</th>
                            <td>{{ \Carbon\Carbon::parse($requisicao->data)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Tipo:</th>
                            <td>{{ $requisicao->tipo_nome }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Contrato:</th>
                            <td>{{ $requisicao->empresa->pessoa->nome_razao_social }}</td>
                        </tr>                        
                        <tr>
                            <th class="col-md-3">Centro de Custo:</th>
                            <td>{{ $requisicao->requisitante->nome }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Solicitante:</th>
                            <td>{{ $requisicao->solicitante->nome }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Veículo:</th>
                            <td>{{ ($requisicao->veiculo) ? $requisicao->veiculo->placa . ' - ' . $requisicao->veiculo->marca . ' - ' . $requisicao->veiculo->modelo : "" }}
                            </td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Local de entrega:</th>
                            <td>
                                <p style="white-space: pre-wrap">{{ $requisicao->local_entrega }}</p>
                            </td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Situação:</th>
                            <td>{{ $requisicao->situacao_nome }}</td>
                        </tr>
                        @if ($requisicao->situacao == \App\RequisicaoCompra::SITUACAO_AUTORIZADA)
                            <tr>
                                <th class="col-md-3">Usuário Autorizador:</th>
                                <td>{{ ($requisicao->usuarioAutorizacao) ? $requisicao->usuarioAutorizacao->name : "Usuário não cadastrado" }}</td>
                            </tr>
                            <tr>
                                <th class="col-md-3">Data da Autorização:</th>
                                <td>{{ ($requisicao->data_autorizacao) ? \Carbon\Carbon::parse($requisicao->data_autorizacao)->format('d/m/Y') : "" }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th class="col-md-3">Observação:</th>
                            <td>
                                <p style="white-space: pre-wrap">{{ $requisicao->obsrvacao }}</p>
                            </td>
                        </tr>
                        <tr>
                            <th class="col-md-3">Urgente:</th>
                            <td>{{ $requisicao->urgente ? 'Sim' : 'Não' }}</td>
                        </tr>
                        <tr>
                            <th>Usuário que Cadastrou:</th>
                            <td>{{ ($requisicao->usuarioCadastrou) ? $requisicao->usuarioCadastrou->name : "" }}</td>
                        </tr>
                        <tr>
                            <th>Criado:</th>
                            <td>{{ \Carbon\Carbon::parse($requisicao->created_at)->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Usuário que Alterou:</th>
                            <td>{{ ($requisicao->usuarioAlterou) ? $requisicao->usuarioAlterou->name : "" }}</td>
                        <tr>
                            <th>Alterado:</th>
                            <td>{{ \Carbon\Carbon::parse($requisicao->updated_at)->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <!-- Fim cabeçalho -->
                    </table>
                </div>
                <!-- Tab de Itens -->
                <div class="tab-pane fade" id="tabs-itens" role="tabpanel" aria-labelledby="tabs-itens-tab">
                    <div class="card">
                        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">
                            <!-- Criação da tabela -->
                            <table class="table table-striped table-hover">
                                <!-- Table head dos itens -->
                                <thead>
                                    <tr>
                                        <th class="col-md-1 col-1">Item</th>
                                        <th class="col-md-5 col-7">Produto/Serviço</th>
                                        <th class="col-md-3 col-2">Unidade</th>
                                        <th class="col-md-3 col-2">Quantidade solicitada</th>
                                    </tr>
                                </thead>
                                @if ($requisicao->itens->count() == 0)
                                    <tr>
                                        <th class="text-center" colspan="6">Nenhum item informado</th>
                                    </tr>
                                @else
                                    @foreach ($requisicao->itens as $item)
                                        <!-- Table row dos itens -->
                                        <tr>
                                            <td>{{ $item->item }}</td>
                                            <td class="text"><p style="white-space: pre-wrap">{{ $item->descricao }}</p></td>
                                            <td class="text">{{ $item->unidade }}</td>
                                            <td class="text-right">{{ $item->quantidade_solicitada }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('requisicoes-compras.edit', $requisicao->id) }}" class="btn btn-primary"
                title="Editar">Editar</a>
            <a class="btn btn-danger" href="{{ route('requisicoes-compras.index') }}">Voltar</a>
            <a href="{{ route('requisicoes-compras.gera.pdf', $requisicao->id) }}" class="btn btn-success" title="download"
                target="_blank">Demonstrativo</a>
            <div class="btn-group dropleft">
                {!! Form::open([
                    'id' => 'form_cotar_' . $requisicao->id,
                    'method' => 'put',
                    'route' => ['requisicoes-compras.cotar', $requisicao->id],
                    'style' => 'display: inline',
                ]) !!}
                {!! Form::button('<i class="fa fa-tty"></i> Cotar', ['class' => 'btn btn-success modal-cotar-requisicao', 'title' => 'Cotar']) !!}
                {!! Form::close() !!}
            </div>        
        </div>
    </div>
@endsection
@section('scripts')
{!! Html::script('js/modal-cotar-requisicao.js') !!}
@endsection
