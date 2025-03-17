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
                    <th class="col-md-2">Data:</th>
                    <td>{{ $requisicao->data }}</td>
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
                    <th class="col-md-2">Placa:</th>
                    <td>{{ $requisicao->veiculo->placa }}</td>
                </tr>
                <tr>
                    <th class="col-md-2">Marca:</th>
                    <td>{{ $requisicao->veiculo->marca }}</td>
                </tr>
                <tr>
                    <th class="col-md-2">Modelo:</th>
                    <td>{{ $requisicao->veiculo->modelo }}</td>
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
