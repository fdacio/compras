@extends('layouts.app')
@section('title', 'Produtos')

@section('content')
    <div class="card mb-2">
        <div class="card-header">
            <h3>Produtos</h3>
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
            <form action="{{ route('produtos.index') }}" method="get" class="form-filter">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="id">Código</label>
                        <input type="text" name="id" id="id" class="form-control" value="{{ request('id') }}" />
                    </div>
                    <div class="form-group col-md-10">
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
                <a href="{{ route('produtos.create') }}" class="btn btn-primary"><i
                        class="fa fa-plus mr-2"></i>Cadastrar</a>
            </div>
        </div>
    </div>

    <section class="table-responsive">

        <table class="table table-striped table-hover">
            <thead>
                <th>Código</th>
                <th>Nome</th>
                <th>Unidade</th>
                <th class="text-right text-nowrap">Vr.Unitário</th>
                <th style="width: 15%;"></th>
            </thead>
            <tbody>
                @if ($produtos->total() == 0)
                    <tr>
                        <th class="text-center" colspan="6">Nenhum produto encontrada</th>
                    </tr>
                @else
                    @foreach ($produtos as $produto)
                        <tr>
                            <td>{{ $produto->id }}</td>
                            <td>{{ $produto->nome }}</td>
                            <td>{{ $produto->unidade->nome }}</td>
                            <td class="text-right text-nowrap">{{ 'R$ ' . number_format($produto->valor_unitario, '2', ',', '.') }}</td>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('produtos.show', $produto->id) }}" class="btn btn-info btn-sm"
                                    title="Visualizar"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-primary btn-sm"
                                    title="Editar"><i class="fa fa-pencil"></i></a>
                                <a href="{{ route('produtos.duplicate', $produto->id) }}" class="btn btn-success btn-sm"
                                    title="Duplicar"><i class="fa fa-clone"></i></a>
                                @if ($produtos->total() > 0)
                                    {!! Form::open(['id' => 'form_excluir_' . $produto->id, 'method' => 'delete', 'route' => ['produtos.destroy', $produto->id], 'style' => 'display: inline']) !!}
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
        {{ $produtos->appends(request()->query())->links() }}
        <h6><b>{{ $produtos->total() }}</b> {{ $produtos->total() == 1 ? 'registro' : 'registros' }} no total</h6>
    </section>
@endsection

@if ($produtos->total() > 0)
    @section('scripts')
        {!! Html::script('js/modal-excluir.js') !!}
    @endsection
@endif
