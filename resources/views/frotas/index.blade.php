@extends('layouts.app')
@section('title', 'Frotas')

@section('content')
<div class="card mb-2">
    <div class="card-header">
        <h3>Frotas</h3>
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
        <form action="{{ route('frotas.index') }}" method="get" class="form-filter">
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
            <a href="{{ route('frotas.create') }}" class="btn btn-primary"><i class="fa fa-plus mr-2"></i>Cadastrar</a>
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
            @if($frotas->total() == 0)
            <tr>
                <th class="text-center" colspan="6">Nenhum órgao encontrada</th>
            </tr>
            @else
            @foreach ($frotas as $frota)
            <tr>
                <td>{{ $frota->id }}</td>
                <td>{{ $frota->nome }}</td>
                
                <td class="text-right text-nowrap">
                    <a href="{{ route('frotas.show', $frota->id) }}" class="btn btn-info" title="Visualizar"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('frotas.edit', $frota->id) }}" class="btn btn-primary" title="Editar"><i class="fa fa-pencil"></i></a>
                    @if($frotas->total() > 0)
                    {!! Form::open(['id' => 'form_excluir_' . $frota->id, 'method' => 'delete', 'route' => ['frotas.destroy', $frota->id], 'style'=>'display: inline']) !!}
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
    {{ $frotas->appends(request()->query())->links() }}
    <h6><b>{{ $frotas->total() }}</b> {{ $frotas->total() == 1 ? 'registro' : 'registros' }} no total</h6>
</section>
@endsection

@if($frotas->total() > 0)
@section('scripts')
{!! Html::script('js/modal-excluir.js') !!}
@endsection
@endif
