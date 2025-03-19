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
                        aria-controls="tabs-cabecalho"
                        aria-selected="true">Cabeçalho</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tabs-itens-tab" data-toggle="pill" href="#tabs-itens" role="tab"
                        aria-controls="tabs-itens"
                        aria-selected="false">Itens</a>
                </li>
            </ul>
            <!-- Começo das tabs-->
            <div class="tab-content" id="tabs-tabContent">
                <!-- Tab Cabeçalho-->
                <div class="tab-pane fade show active" id="tabs-cabecalho" role="tabpanel" aria-labelledby="tabs-cabecalho-tab">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th class="col-md-2">ID:</th>
                            <td>{{ $requisicao->id }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-2">Data:</th>
                            <td>{{ \Carbon\Carbon::parse($requisicao->data)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-2">Tipo:</th>
                            <td>{{ $requisicao->tipo_nome }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-2">Requisitante:</th>
                            <td>{{ $requisicao->requisitante->nome }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-2">Solicitante:</th>
                            <td>{{ $requisicao->solicitante->nome }}</td>
                        </tr>
                        <tr>
                            <th class="col-md-2">Veículo:</th>
                            <td>{{ $requisicao->veiculo->placa . ' - ' . $requisicao->veiculo->marca . ' - ' . $requisicao->veiculo->modelo }}</td>
                        </tr>
                        <tr>
                            <th>Criado:</th>
                            <td>{{ \Carbon\Carbon::parse($requisicao->created_at)->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Alterado:</th>
                            <td>{{ \Carbon\Carbon::parse($requisicao->updated_at)->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <!-- Fim cabeçalho -->
                    </table>
                </div>
                <!-- Tab de Itens -->
                <div class="tab-pane fade" id="tabs-itens" role="tabpanel" aria-labelledby="tabs-itens-tab">
                    <table class="table table-striped table-hover">
                        @foreach ($requisicao->itens as $item)
                            <tr>
                                <th class="col-md-2">Item:</th>
                                <td>{{ $item->item }}</td>
                            </tr>
                            <tr>
                                <th class="col-md-2">Produto/Serviço:</th>
                                <td>{{ $item->descricao }}</td>
                            </tr>
                            <tr>
                                <th class="col-md-2">Unidade:</th>
                                <td>{{ $item->unidade }}</td>
                            </tr>
                            <tr>
                                <th class="col-md-2">Quantidade solicitada:</th>
                                <td>{{ $item->quantidade_solicitada }}</td>
                            </tr>
                            <tr>
                                <th class="col-md-2">Quantidade a cotar:</th>
                                <td>{{ $item->quantidade_a_cotar }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('requisicoes-compras.edit', $requisicao->id) }}" class="btn btn-primary" title="Editar">Editar</a>
            <a class="btn btn-danger" href="{{ route('requisicoes-compras.index') }}">Cancelar</a>
        </div>
    </div>
@endsection
