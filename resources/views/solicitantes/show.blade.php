@extends('layouts.app')
@section('title', 'Solicitante - Visualizar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Visualizar Solicitante</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <tr>
                    <th class="col-md-2">ID:</th>
                    <td>{{ $solicitante->id }}</td>
                </tr>
                <tr>
                    <th>Nome:</th>
                    <td>{{ $solicitante->nome }}</td>
                </tr>
                <tr>
                    <th>Criado:</th>
                    <td>{{ \Carbon\Carbon::parse($solicitante->created_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Alterado:</th>
                    <td>{{ \Carbon\Carbon::parse($solicitante->updated_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('solicitantes.edit', $solicitante->id) }}" class="btn btn-primary" title="Editar">Editar</a>
            <a class="btn btn-danger" href="{{ route('solicitantes.index') }}">Cancelar</a>
        </div>
    </div>
@endsection
