@extends('layouts.app')
@section('title', 'Usuários - Editar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Editar Usuário</h3>
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
        </div>
        {!! Form::open(['id' => 'form_user', 'method' => 'patch', 'route' => ['user.update', $user->id], 'autocomplete' => 'off']) !!}
        <div class="card-body">
            @include('user.form')
        </div>
        <div class="card-footer">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-danger " href="{{ route('user.index') }}">Cancelar</a>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
