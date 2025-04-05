@extends('layouts.app')
@section('title', 'Favorecido - Visualizar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Visualizar Favorecido</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover table-responsive">
                <tr>
                    <th class="col-md-2">ID:</th>
                    <td>{{ $favorecido->id }}</td>
                </tr>
                <tr>
                    <th>CNPJ:</th>
                    <td>{{ Formatter::cpfCnpj($favorecido->pessoa->pessoaJuridica->cnpj) }}</td>
                </tr>
                <tr>
                    <th>Razão Social</th>
                    <td>{{ $favorecido->pessoa->pessoaJuridica->razao_social }}</td>
                </tr>
                <tr>
                    <th>CGF:</th>
                    <td>{{ $favorecido->pessoa->pessoaJuridica->cgf }}</td>
                </tr>
                <tr>
                    <th>Nome Fantasia:</th>
                    <td>{{ $favorecido->pessoa->pessoaJuridica->nome_fantasia }}</td>
                </tr>
                <tr>
                    <th>Endereço:</th>
                    <td>{{ $favorecido->pessoa->endereco_completo }}</td>
                </tr>
                <tr>
                    <th>Cidade:</th>
                    <td>{{ $favorecido->pessoa->cidade->nome . ' - ' . $favorecido->pessoa->cidade->estado->nome }}</td>
                </tr>
                <tr>
                    <th>Telefone:</th>
                    <td>{{ Formatter::telefone($favorecido->pessoa->telefone) }}</td>
                </tr>
                <tr>
                    <th>Celular:</th>
                    <td>{{ Formatter::celular($favorecido->pessoa->celular) }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ $favorecido->pessoa->email }}</td>
                </tr>
                <tr>
                    <th>Banco:</th>
                    <td>{{ $favorecido->banco }}</td>
                </tr>
                <tr>
                    <th>Agência:</th>
                    <td>{{ $favorecido->agencia }}</td>
                </tr>
                <tr>
                    <th>Conta:</th>
                    <td>{{ $favorecido->conta }}</td>
                </tr>
                <tr>
                    <th>Operação:</th>
                    <td>{{ $favorecido->operação }}</td>
                </tr>
                <tr>
                    <th>Chave PIX:</th>
                    <td>{{ $favorecido->chave_pix }}</td>
                <tr>
                    <th>Criado:</th>
                    <td>{{ \Carbon\Carbon::parse($favorecido->created_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Alterado:</th>
                    <td>{{ \Carbon\Carbon::parse($favorecido->updated_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('favorecidos.edit', $favorecido->id) }}" class="btn btn-primary" title="Editar">Editar</a>
            <a class="btn btn-danger" href="{{ route('favorecidos.index') }}">Cancelar</a>
        </div>
    </div>
@endsection
