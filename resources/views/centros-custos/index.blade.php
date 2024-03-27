@extends('layouts.app')
@section('title', 'Centros de Custos')

@section('content')
<div class="card mb-2">
    <div class="card-header">
        <h3>Centros de Custos</h3>
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
        <form action="{{ route('centros-custos.index') }}" method="get" class="form-filter">
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="nome">Nome</label>
                    <div class="input-group">
                        <input type="text" name="nome" id="nome" class="form-control" value="{{ request('nome') }}" />
                        <div class="input-group-append">
                            <button class="btn btn-success"><i class="fa fa-search mr-2"></i><span>Pesquisar</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <div class="text-right mb-2">
            <a href="{{ route('centros-custos.create') }}" class="btn btn-primary"><i class="fa fa-plus mr-2"></i>Cadastrar</a>
        </div>
    </div>
</div>

<section class="table-responsive">

    <table class="table table-striped table-hover">
        <thead>
            <th>ID</th>
            <th>Nome</th>
            <th style="width: 20%;"></th>
        </thead>
        <tbody>
            @if($centrosCustos->total() == 0)
            <tr>
                <th class="text-center" colspan="6">Nenhum órgao encontrada</th>
            </tr>
            @else
            @foreach ($centrosCustos as $centroCusto)
            <tr>
                <td>{{ $centroCusto->id }}</td>
                <td>{{ $centroCusto->nome }}</td>
                
                <td class="text-right text-nowrap">
                    <a href="{{ route('centros-custos.show', $centroCusto->id) }}" class="btn btn-info" title="Visualizar"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('centros-custos.edit', $centroCusto->id) }}" class="btn btn-primary" title="Editar"><i class="fa fa-pencil"></i></a>
                    @if($centrosCustos->total() > 0)
                    {!! Form::open(['id' => 'form_excluir_' . $centroCusto->id, 'method' => 'delete', 'route' => ['centros-custos.destroy', $centroCusto->id], 'style'=>'display: inline']) !!}
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
    {{ $centrosCustos->appends(request()->query())->links() }}
    <h6><b>{{ $centrosCustos->total() }}</b> {{ $centrosCustos->total() == 1 ? 'registro' : 'registros' }} no total</h6>
</section>
@endsection

@if($centrosCustos->total() > 0)
@section('scripts')
{!! Html::script('js/modal-excluir.js') !!}
@endsection
@endif
