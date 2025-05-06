@extends('layouts.app')
@section('title', 'Cotação - Visualizar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Visualizar Cotação</h2>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span
                            aria-hidden="true">&times;</span></button>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('danger'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span
                            aria-hidden="true">&times;</span></button>
                    {{ session('danger') }}
                </div>
            @endif
        </div>
        <div class="card-body">
            <!-- Tabs Links-->
            <ul class="nav nav-tabs mb-2" id="tabs-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tabs-cabecalho-tab" data-toggle="pill" href="#tabs-cabecalho"
                        role="tab" aria-controls="tabs-cabecalho" aria-selected="true">Cotação</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tabs-requisicao-tab" data-toggle="pill" href="#tabs-requisicao" role="tab"
                        aria-controls="tabs-requisicao" aria-selected="true">Requisição</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tabs-fornecedores-tab" data-toggle="pill" href="#tabs-fornecedores"
                        role="tab" aria-controls="tabs-itens" aria-selected="false">Fornecedores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tabs-vencedores-tab" data-toggle="pill" href="#tabs-vencedores" role="tab"
                        aria-controls="tabs-itens" aria-selected="false">Vencedor</a>
                </li>

            </ul>
            <!-- Começo das tabs-->
            <div class="tab-content" id="tabs-tabContent">
                <!-- Tab Cabeçalho-->
                <div class="tab-pane fade show active" id="tabs-cabecalho" role="tabpanel"
                    aria-labelledby="tabs-cabecalho-tab">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th class="col-md-3">Nº:</th>
                                    <td>{{ $cotacao->id }}</td>
                                </tr>
                                <tr>
                                    <th class="col-md-3">Data:</th>
                                    <td>{{ \Carbon\Carbon::parse($cotacao->data)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="col-md-3">Finalizada:</th>
                                    <td>{{ $cotacao->finalizada ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <th>Usuário que Cadastrou:</th>
                                    <td>{{ $cotacao->usuarioCadastrou ? $cotacao->usuarioCadastrou->name : '' }}</td>
                                </tr>
                                <tr>
                                    <th>Criado:</th>
                                    <td>{{ \Carbon\Carbon::parse($cotacao->created_at)->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Usuário que Alterou:</th>
                                    <td>{{ $cotacao->usuarioAlterou ? $cotacao->usuarioAlterou->name : '' }}</td>
                                <tr>
                                    <th>Alterado:</th>
                                    <td>{{ \Carbon\Carbon::parse($cotacao->updated_at)->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <!-- Fim cabeçalho -->
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Tab de Requisição -->
                <div class="tab-pane fade" id="tabs-requisicao" role="tabpanel" aria-labelledby="tabs-requisicao-tab">
                    <div class="card">
                        <div class="card-body">
                            @include('cotacoes.fragments.dados-requisicao')
                        </div>
                    </div>
                </div>
                <!-- Fim Tab de Requisição -->

                <!-- Tab de Fornecedores -->
                <div class="tab-pane fade" id="tabs-fornecedores" role="tabpanel" aria-labelledby="tabs-fornecedores-tab">
                    <div class="card">
                        <div class="card-body">
                            @foreach ($cotacao->fornecedores as $item)
                                <div class="card-header border-0 my-2">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div id="accordion-itens-{{ $item->id }}" class="accordion">
                                                <a class="card-link" data-toggle="collapse"
                                                    href="#itens-{{ $item->id }}">
                                                    {{ $item->fornecedor->pessoa->nome_razao_social }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="itens-{{ $item->id }}" class="collapse hide"
                                    data-parent="#accordion-itens-{{ $item->id }}">

                                    @include('cotacoes.fragments.itens-fornecedor-show')

                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                <!-- Fim Tab de Fornecedores -->

                <!-- Tab de Vencedores -->
                <div class="tab-pane fade" id="tabs-vencedores" role="tabpanel" aria-labelledby="tabs-vencedores-tab">
                    <div class="card">
                        @if ($cotacao->finalizada)
                            @include('cotacoes.fragments.fornecedores-vencedores')
                        @else
                            <div class="card-body">
                                <div class="alert alert-warning">
                                    <strong>Cotação ainda não finalizada.</strong>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Fim Tab de Vencedores -->
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('cotacoes.edit', $cotacao->id) }}" class="btn btn-primary" title="Editar">Editar</a>
            <a href="{{ route('cotacoes.gera.pdf', $cotacao->id) }}" class="btn btn-danger" title="download"
                target="_blank">Demonstrativo</a>
            <div class="btn-group dropleft">
                {!! Form::open([
                    'id' => 'form_finaliza_cotacao_' . $cotacao->id,
                    'method' => 'put',
                    'route' => ['cotacoes.finalizar', $cotacao->id],
                    'style' => 'display: inline',
                ]) !!}
                {!! Form::button('Finalizar Cotação', [
                    'class' => 'btn btn-success modal-finalizar-cotacao',
                    'title' => 'Finalizar Cotação',
                ]) !!}
                {!! Form::close() !!}
            </div>
            <a class="btn btn-danger" href="{{ url()->previous() }}">Voltar</a>
        </div>
    </div>
@endsection
@section('scripts')
    {!! Html::script('js/modal-finalizar-cotacao.js') !!}
@endsection
