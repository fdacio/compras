@extends('layouts.app')
@section('title', 'Usuários - Visualizar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Visualizar Usuário</h3>
        </div>

        <div class="card-body">
            <table class="table table-striped table-hover">
                <tr>
                    <th style="width:10%">ID:</th>
                    <td>{{ $user->id }}</td>
                </tr>
                <tr>
                    <th>Nome:</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Tipo:</th>
                    <td>{{ $user->tipo->nome }}</td>
                </tr>
                <tr>
                    <th>Cadastro:</th>
                    <td>{{ \Carbon\Carbon::parse($user->created)->format('d/m/Y') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary" title="Editar">Editar</a>
            <a class="btn btn-danger" href="{{ route('user.index') }}">Voltar</a>
        </div>
    </div>
@endsection
