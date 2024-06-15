@extends('layouts.app')
@section('title', 'Produtos - Visualizar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Visualizar Produto</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <tr>
                    <th class="col-md-2">ID:</th>
                    <td>{{ $produto->id }}</td>
                </tr>
                <tr>
                    <th>Nome:</th>
                    <td>{{ $produto->nome }}</td>
                </tr>
                <tr>
                    <th>Unidade</th>
                    <td>{{ $produto->unidade->nome }}</td>
                </tr>
                <tr>
                    <th>Valor Unitário:</th>
                    <td>{{ 'R$ ' . number_format($produto->valor_unitario, '2', ',', '.') }}</td>
                </tr>

                <tr>
                    <th>Criado:</th>
                    <td>{{ \Carbon\Carbon::parse($produto->created_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Alterado:</th>
                    <td>{{ \Carbon\Carbon::parse($produto->updated_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-primary" title="Editar">Editar</a>
            <a class="btn btn-danger" href="{{ route('produtos.index') }}">Cancelar</a>
        </div>
    </div>
@endsection
