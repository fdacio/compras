@extends('layouts.app')
@section('title', 'Veículo - Visualizar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Visualizar Veículo</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <tr>
                    <th class="col-md-2">ID:</th>
                    <td>{{ $veiculo->id }}</td>
                </tr>
                <tr>
                    <th>Empresa:</th>
                    <td>{{ $veiculo->empresa->pessoa->nome_razao_social }}</td>
                </tr>
                <tr>
                    <th>Frota:</th>
                    <td>{{ $veiculo->frota->nome }}</td>
                </tr>
                <tr>
                    <th>Centro de Custo:</th>
                    <td>{{ $veiculo->centroCusto->nome }}</td>
                </tr>
                <tr>
                    <th>Tipo:</th>
                    <td>{{ $veiculo->tipoVeiculo->nome }}</td>
                </tr>
                <tr>
                    <th>Marca:</th>
                    <td>{{ $veiculo->marca }}</td>
                </tr>
                <tr>
                    <th>Modelo:</th>
                    <td>{{ $veiculo->modelo }}</td>
                </tr>
                <tr>
                    <th>Placa:</th>
                    <td>{{ $veiculo->placa }}</td>
                </tr>
                <tr>
                    <th>UF:</th>
                    <td>{{ $veiculo->uf }}</td>
                </tr>
                <tr>
                    <th>Cor:</th>
                    <td>{{ $veiculo->cor }}</td>
                </tr>
                <tr>
                    <th>Ano:</th>
                    <td>{{ $veiculo->ano }}</td>
                </tr>
                <tr>
                    <th>Renavan:</th>
                    <td>{{ $veiculo->renavan }}</td>
                </tr>
                <tr>
                    <th>Chassi</th>
                    <td>{{ $veiculo->chassi }}</td>
                </tr>
                <tr>
                    <th>Criado:</th>
                    <td>{{ \Carbon\Carbon::parse($veiculo->created_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Alterado:</th>
                    <td>{{ \Carbon\Carbon::parse($veiculo->updated_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('veiculos.edit', $veiculo->id) }}" class="btn btn-primary" title="Editar">Editar</a>
            <a class="btn btn-danger" href="{{ route('veiculos.index') }}">Cancelar</a>
        </div>
    </div>
@endsection
