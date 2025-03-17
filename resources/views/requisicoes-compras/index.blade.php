@extends('layouts.app')
@section('title', 'Requisições de Compras')

@section('content')
    <div class="card mb-2">
        <div class="card-header">
            <h3>Requisições de Compras</h3>
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
            <form action="{{ route('requisicoes-compras.index') }}" method="get" class="form-filter">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="id-requisitante">Requisitante</label>
                        <div class="input-group">
                            {!! Form::select('id_requisitante', $requisitantes, request('id_requisitante'), [
                                'placeholder' => 'Todos',
                                'class' => 'form-control select',
                                'id' => 'id_requisitante',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="id-solicitante">Solicitante</label>
                        <div class="input-group">
                            {!! Form::select('id_solicitante', $solicitantes, request('id_solicitante'), [
                                'placeholder' => 'Todos',
                                'class' => 'form-control select',
                                'id' => 'id_solicitante',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="id-veiculo">Veículo</label>
                        <div class="input-group">
                            {!! Form::select('id_veiculo', $veiculos, request('id_veiculo'),
                                ['placeholder' => 'Todos', 
                                'class' => 'form-control select', 
                                'id' => 'id_veiculo'],
                            ) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 text-right">
                        <button class="btn btn-success"><i
                            class="fa fa-search mr-2"></i><span>Pesquisar</span></button>

                    </div>
                </div>    
            </form>
        </div>
        <div class="card-footer">
            <div class="text-right mb-2">
                <a href="{{ route('requisicoes-compras.create') }}" class="btn btn-primary"><i
                        class="fa fa-plus mr-2"></i>Cadastrar</a>
            </div>
        </div>
    </div>
    <section class="table-responsive">

        <table class="table table-striped table-hover">
            <thead>
                <th>Código</th>
                <th>Data</th>
                <th>Requisitante</th>
                <th>Solicitante</th>
                <th>Veículo</th>
                <th style="width: 15%;"></th>
            </thead>
            <tbody>
                @if ($requisicoes->total() == 0)
                    <tr>
                        <th class="text-center" colspan="6">Nenhuma requisição encontrada</th>
                    </tr>
                @else
                    @foreach ($requisicoes as $requisicao)
                        <tr>
                            <td>{{ $requisicao->id }}</td>
                            <td>{{ $requisicao->data }}</td>
                            <td>{{ $requisicao->requisitante->nome }}</td>
                            <td>{{ $requisicao->solicitante->nome }}</td>
                            <td>{{ $requisicao->veiculo->placa . ' - ' . $requisicao->veiculo->marca . ' - ' . $requisicao->veiculo->modelo }}</td>
                            <td class="text-right text-nowrap">{{ 'R$ ' . number_format($requisicao->valor_unitario, '2', ',', '.') }}</td>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('requisicoes-compras.show', $requisicao->id) }}" class="btn btn-info btn-sm"
                                    title="Visualizar"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('requisicoes-compras.edit', $requisicao->id) }}" class="btn btn-primary btn-sm"
                                    title="Editar"><i class="fa fa-pencil"></i></a>
                                @if ($requisicao->total() > 0)
                                    {!! Form::open(['id' => 'form_excluir_' . $requisicao->id, 'method' => 'delete', 'route' => ['requisicoes-compras.destroy', $produto->id], 'style' => 'display: inline']) !!}
                                    {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger btn-sm modal-excluir']) !!}
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
        {!! Html::script('js/modal-excluir.js') !!}
    @endsection
@endif
