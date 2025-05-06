@extends('layouts.app')
@section('title', 'Autoriações de Requisições de Compras')

@section('content')
    <div class="card mb-2">
        <div class="card-header">
            <h3>Autoriações de Requisições de Compras</h3>
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
            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span
                            aria-hidden="true">&times;</span></button>
                    {{ session('warning') }}
                </div>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('requisicoes-compras.cotadas.autorizacoes') }}" method="get" class="form-filter">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="numero_requisicao">Número da Requisição</label>
                        <div class="input-group">
                            <input type="text" name="numero_requisicao" id="numero_requisicao" class="form-control"
                                value="{{ request('numero_requisicao') }}" />
                            <div class="input-group-append">
                                <button class="btn btn-success"><i
                                        class="fa fa-search mr-2"></i><span>Pesquisar</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
        </div>
    </div>
    <section class="table-responsive">

        <table class="table table-striped table-hover">
            <thead>
                <th>Código</th>
                <th>Data</th>
                <th>Centro de Custo</th>
                <th>Solicitante</th>
                <th>Veículo</th>
                <th>Tipo</th>
                <th>Situação</th>
                <th style="width: 15%;"></th>
            </thead>
            <tbody>
                @if ($requisicoes->total() == 0)
                    <tr>
                        <th class="text-center" colspan="10">Nenhuma requisição encontrada</th>
                    </tr>
                @else
                    @foreach ($requisicoes as $requisicao)
                        <tr>
                            <td>{{ $requisicao->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($requisicao->data)->format('d/m/Y') }}</td>
                            <td>{{ $requisicao->requisitante->nome }}</td>
                            <td>{{ $requisicao->solicitante->nome }}</td>
                            <td>{{ $requisicao->veiculo ? $requisicao->veiculo->placa . ' - ' . $requisicao->veiculo->marca . ' - ' . $requisicao->veiculo->modelo : '' }}
                            </td>
                            <td>{{ $requisicao->tipo_nome }}</td>
                            <td>{{ $requisicao->situacao_nome }}</td>
                            <td class="text-right text-nowrap">

                                <a href="{{ route('requisicoes-compras.show', $requisicao->id) }}"
                                    class="btn btn-info btn-sm" title="Visualizar Requisição"><i class="fa fa-eye"></i></a>

                                <a href="{{ route('cotacoes.show', $requisicao->cotacao->id) }}"
                                    class="btn btn-info btn-sm" title="Visualizar Cotação"><i class="fa fa-eye"></i></a>
    

                                @if ($requisicoes->total() > 0)
                                    {!! Form::open([
                                        'id' => 'form_autorizar_' . $requisicao->id,
                                        'method' => 'put',
                                        'route' => ['requisicoes-compras.autorizar', $requisicao->id],
                                        'style' => 'display: inline',
                                    ]) !!}
                                    {!! Form::button('<i class="fa fa-check"></i>', [
                                        'class' => 'btn btn-success btn-sm modal-autorizar',
                                        'title' => 'Autorizar Comprar',
                                    ]) !!}
                                    {!! Form::close() !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </section>

    <section class="text-center">
        {{ $requisicoes->appends(request()->query())->links() }}
        <h6><b>{{ $requisicoes->total() }}</b> {{ $requisicoes->total() == 1 ? 'registro' : 'registros' }} no total</h6>
    </section>
@endsection

@if ($requisicoes->total() > 0)
    @section('scripts')
        {!! Html::script('js/modal-autorizar.js') !!}
    @endsection
@endif
