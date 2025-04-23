@extends('layouts.app')
@section('title', 'Fornecedor - Visualizar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Visualizar Fornecedor</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover table-responsive">
                <tr>
                    <th class="col-md-2">ID:</th>
                    <td>{{ $fornecedor->id }}</td>
                </tr>
                <tr>
                    <th>CNPJ:</th>
                    <td>{{ Formatter::cpfCnpj($fornecedor->pessoa->pessoaJuridica->cnpj) }}</td>
                </tr>
                <tr>
                    <th>Razão Social</th>
                    <td>{{ $fornecedor->pessoa->pessoaJuridica->razao_social }}</td>
                </tr>
                <tr>
                    <th>CGF:</th>
                    <td>{{ $fornecedor->pessoa->pessoaJuridica->cgf }}</td>
                </tr>
                <tr>
                    <th>Nome Fantasia:</th>
                    <td>{{ $fornecedor->pessoa->pessoaJuridica->nome_fantasia }}</td>
                </tr>
                <tr>
                    <th>Endereço:</th>
                    <td>{{ $fornecedor->pessoa->endereco_completo }}</td>
                </tr>
                <tr>
                    <th>Cidade:</th>
                    <td>{{ ($fornecedor->pessoa->cidade) ? $fornecedor->pessoa->cidade->nome . ' - ' . $fornecedor->pessoa->cidade->estado->nome : ""}}</td>
                </tr>
                <tr>
                    <th>Telefone:</th>
                    <td>{{ Formatter::telefone($fornecedor->pessoa->telefone) }}</td>
                </tr>
                <tr>
                    <th>Celular:</th>
                    <td>{{ Formatter::celular($fornecedor->pessoa->celular) }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ $fornecedor->pessoa->email }}</td>
                </tr>
                <tr>
                    <th>Banco:</th>
                    <td>{{ $fornecedor->banco }}</td>
                </tr>
                <tr>
                    <th>Agência:</th>
                    <td>{{ $fornecedor->agencia }}</td>
                </tr>
                <tr>
                    <th>Conta:</th>
                    <td>{{ $fornecedor->conta }}</td>
                </tr>
                <tr>
                    <th>Operação:</th>
                    <td>{{ $fornecedor->operação }}</td>
                </tr>
                <tr>
                    <th>Chave PIX:</th>
                    <td>{{ $fornecedor->chave_pix }}</td>
                <tr>
                    <th>Criado:</th>
                    <td>{{ \Carbon\Carbon::parse($fornecedor->created_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Alterado:</th>
                    <td>{{ \Carbon\Carbon::parse($fornecedor->updated_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('fornecedores.edit', $fornecedor->id) }}" class="btn btn-primary" title="Editar">Editar</a>
            <a class="btn btn-danger" href="{{ route('fornecedores.index') }}">Cancelar</a>
        </div>
    </div>
@endsection
