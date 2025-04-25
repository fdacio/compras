@extends('layouts.app')
@section('title', 'Cotações')

@section('content')
<div class="card mb-2">
    <div class="card-header">
        <h3>Cotações</h3>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
            {{ session('success') }}
        </div>
        @endif
        @if(session('danger'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
            {{ session('danger') }}
        </div>
        @endif
    </div>
    <div class="card-body">
        <form action="{{ route('cotacoes.index') }}" method="get" class="form-filter">
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="numero_requisicao">Número da Requisição</label>
                    <div class="input-group">
                        <input type="text" name="numero_requisicao" id="numero_requisicao" class="form-control" value="{{ request('numero_requisicao') }}" />
                        <div class="input-group-append">
                            <button class="btn btn-success"><i class="fa fa-search mr-2"></i><span>Pesquisar</span></button>
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
            <th>ID</th>
            <th>Data</th>
            <th>Número da Requisição</th>
            <th style="width: 20%;"></th>
        </thead>
        <tbody>
            @if($cotacoes->total() == 0)
            <tr>
                <th class="text-center" colspan="6">Nenhuma cotação encontrada</th>
            </tr>
            @else
            @foreach ($cotacoes as $cotacao)
            <tr>
                <td>{{ $cotacao->id }}</td>
                <td>{{ $cotacao->data }}</td>
                <td>{{ $cotacao->requisicao->id }}</td>
                
                <td class="text-right text-nowrap">
                    <a href="{{ route('cotacoes.show', $cotacao->id) }}" class="btn btn-info" title="Visualizar"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('cotacoes.edit', $cotacao->id) }}" class="btn btn-primary" title="Editar"><i class="fa fa-pencil"></i></a>
                    @if($cotacoes->total() > 0)
                    {!! Form::open(['id' => 'form_excluir_' . $cotacao->id, 'method' => 'delete', 'route' => ['cotacoes.destroy', $cotacao->id], 'style'=>'display: inline']) !!}
                    {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger modal-excluir']) !!}
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
    {{ $cotacoes->appends(request()->query())->links() }}
    <h6><b>{{ $cotacoes->total() }}</b> {{ $cotacoes->total() == 1 ? 'registro' : 'registros' }} no total</h6>
</section>
@endsection

@if($cotacoes->total() > 0)
@section('scripts')
{!! Html::script('js/modal-excluir.js') !!}
@endsection
@endif
