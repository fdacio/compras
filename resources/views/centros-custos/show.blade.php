@extends('layouts.app')
@section('title', 'Centro de Custo - Visualizar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Visualizar Centro de Custo</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <tr>
                    <th class="col-md-2">ID:</th>
                    <td>{{ $centroCusto->id }}</td>
                </tr>
                <tr>
                    <th>Nome:</th>
                    <td>{{ $centroCusto->nome }}</td>
                </tr>
                <tr>
                    <th>Criado:</th>
                    <td>{{ \Carbon\Carbon::parse($centroCusto->created_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Alterado:</th>
                    <td>{{ \Carbon\Carbon::parse($centroCusto->updated_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('centros-custos.edit', $centroCusto->id) }}" class="btn btn-primary" title="Editar">Editar</a>
            <a class="btn btn-danger" href="{{ route('centros-custos.index') }}">Cancelar</a>
        </div>
    </div>
@endsection
