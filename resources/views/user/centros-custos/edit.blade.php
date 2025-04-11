@extends('layouts.app')
@section('title', 'Usuários - Centros de Custos')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Usuário - Centros de Custos</h3>
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
            <h3>{{ $user->nome . " - " . $user->tipo->nome }}</h3>
        </div>
        {!! Form::open(['id' => 'form_user_centros_custos', 'method' => 'put', 'route' => ['user.centros-custos.update', $user->id]]) !!}
        <div class="card-body">
            @include('user.centros-custos.form')
        </div>
        <div class="card-footer">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-danger " href="{{ route('user.index') }}">Cancelar</a>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
