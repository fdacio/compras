@extends('layouts.app')
@section('title', 'Usuários - Alterar Senha')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Usuário - Alterar Senha</h3>
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissable ''">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span
                            aria-hidden="true">&times;</span></button>
                    <strong>Ops!</strong> Verifique os erros.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                {{ session('success') }}
            </div>
            @endif
        </div>
        {!! Form::open(['id' => 'form_usuarios', 'method' => 'put', 'route' => ['user.password.update']]) !!}
        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="senha">Nova Senha:</label>
                        {!! Form::password('password', ['placeholder' => 'Informe a Nova Senha', 'class' => 'form-control', 'id' => 'senha']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="confirma-password">Confirmar Nova Senha:</label>
                        {!! Form::password('password_confirmation', ['placeholder' => 'Confirme a Nova Senha', 'class' => 'form-control', 'id' => 'conforma-password']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            {!! Form::submit('Registrar Nova Senha', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-danger" href="{{ route('home') }}">Cancelar</a>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
