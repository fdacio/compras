@extends('layouts.app')
@section('title', 'Empresa - Visualizar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Visualizar Empresa</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover table-responsive">
                <tr>
                    <th class="col-md-2">ID:</th>
                    <td>{{ $empresa->id }}</td>
                </tr>
                <tr>
                    <th>CNPJ:</th>
                    <td>{{ Formatter::cpfCnpj($empresa->pessoa->pessoaJuridica->cnpj) }}</td>
                </tr>
                <tr>
                    <th>Razão Social</th>
                    <td>{{ $empresa->pessoa->pessoaJuridica->razao_social }}</td>
                </tr>
                <tr>
                    <th>CGF:</th>
                    <td>{{ $empresa->pessoa->pessoaJuridica->cgf }}</td>
                </tr>
                <tr>
                    <th>Nome Fantasia:</th>
                    <td>{{ $empresa->pessoa->pessoaJuridica->nome_fantasia }}</td>
                </tr>
                <tr>
                    <th>Endereço:</th>
                    <td>{{ $empresa->pessoa->endereco_completo }}</td>
                </tr>
                <tr>
                    <th>Ponto de Refência:</th>
                    <td>{{ $empresa->pessoa->ponto_referencia }}</td>
                </tr>
                <tr>
                    <th>Cidade:</th>
                    <td>{{ $empresa->pessoa->cidade->nome . ' - ' . $empresa->pessoa->cidade->estado->nome }}</td>
                </tr>
                <tr>
                    <th>Telefone:</th>
                    <td>{{ Formatter::telefone($empresa->pessoa->telefone) }}</td>
                </tr>
                <tr>
                    <th>Celular:</th>
                    <td>{{ Formatter::celular($empresa->pessoa->celular) }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ $empresa->pessoa->email }}</td>
                </tr>
                <tr>
                    <th>Criado:</th>
                    <td>{{ \Carbon\Carbon::parse($empresa->created_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Alterado:</th>
                    <td>{{ \Carbon\Carbon::parse($empresa->updated_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn btn-primary" title="Editar">Editar</a>
            <a class="btn btn-danger" href="{{ route('empresas.index') }}">Cancelar</a>
        </div>
    </div>
@endsection
