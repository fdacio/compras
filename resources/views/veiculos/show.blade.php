@extends('layouts.app')
@section('title', 'Frota - Visualizar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Visualizar Frota</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <tr>
                    <th class="col-md-2">ID:</th>
                    <td>{{ $frota->id }}</td>
                </tr>
                <tr>
                    <th>Nome:</th>
                    <td>{{ $frota->nome }}</td>
                </tr>
                <tr>
                    <th>Criado:</th>
                    <td>{{ \Carbon\Carbon::parse($frota->created_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Alterado:</th>
                    <td>{{ \Carbon\Carbon::parse($frota->updated_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('frotas.edit', $frota->id) }}" class="btn btn-primary" title="Editar">Editar</a>
            <a class="btn btn-danger" href="{{ route('frotas.index') }}">Cancelar</a>
        </div>
    </div>
@endsection
