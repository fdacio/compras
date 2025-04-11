@extends('layouts.app')
@section('title', 'Usuários - Centros de Custos')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Usuário - Centros de Custos</h3>
            @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                {{ session('success') }}
            </div>
            @endif
            @if(session('danger'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                {{ session('danger') }}
            </div>
            @endif
            <h3>{{ $user->name . " - " . $user->tipo->nome }}</h3>
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
