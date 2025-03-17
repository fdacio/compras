@extends('layouts.app')
@section('title', 'Requisições de Compras - Visualizar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Visualizar Requisições de Compras</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <tr>
                    <th class="col-md-2">ID:</th>
                    <td>{{ $requisicao->id }}</td>
                </tr>


                <tr>
                    <th>Criado:</th>
                    <td>{{ \Carbon\Carbon::parse($requisicao->created_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Alterado:</th>
                    <td>{{ \Carbon\Carbon::parse($requisicao->updated_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('requisicoes-compras.edit', $requisicao->id) }}" class="btn btn-primary" title="Editar">Editar</a>
            <a class="btn btn-danger" href="{{ route('requisicoes-compras.index') }}">Cancelar</a>
        </div>
    </div>
@endsection
