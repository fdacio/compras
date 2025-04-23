@extends('layouts.app')
@section('title', 'Fornecedor - Visualizar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Visualizar fornecedor</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover table-responsive">
                <tr>
                    <th class="col-md-2">ID:</th>
                    <td>{{ $fornecedor->id }}</td>
                </tr>
                <tr>
                    <th>CPF:</th>
                    <td>{{ Formatter::cpfCnpj($fornecedor->pessoa->pessoaFisica->cpf) }}</td>
                </tr>
                <tr>
                    <th>Nome</th>
                    <td>{{ $fornecedor->pessoa->pessoaFisica->nome }}</td>
                </tr>
                <tr>
                    <th>RG:</th>
                    <td>{{ $fornecedor->pessoa->pessoaFisica->rg}}</td>
                </tr>
                <tr>
                    <th>Órgão Emissor:</th>
                    <td>{{ $fornecedor->pessoa->pessoaFisica->rg_orgao }}</td>
                </tr>
                <tr>
                    <th>RG Emissao:</th>
                    <td>{{ \Carbon\Carbon::parse($fornecedor->pessoa->pessoaFisica->rg_emissao)->format('d/m/Y')  }}</td>
                </tr>
                <tr>
                    <th>Nascimento:</th>
                    <td>{{ \Carbon\Carbon::parse($fornecedor->pessoa->pessoaFisica->nacimento)->format('d/m/Y')  }}</td>
                </tr>
                <tr>
                    <th>Sexo:</th>
                    <td>{{ ($fornecedor->pessoa->pessoaFisica->sexo == 'M') ? 'Masculino' : 'Feminino' }}</td>
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
                    <td>{{ $fornecedor->opercao  }}</td>
                </tr>
                <tr>
                    <th>Chave PIX:</th>
                    <td>{{ $fornecedor->chave_pix }}</td>
                </tr>
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
