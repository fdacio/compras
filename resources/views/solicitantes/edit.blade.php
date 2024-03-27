@extends('layouts.app')
@section('title', 'Solicitantes - Alterar')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Alterar Solicitante</h2>
        @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable ''">
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
            <strong>Ops!</strong> Verifique os erros.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    {!! Form::open(array('id' => 'form_grupos', 'method' => 'patch', 'route' => ['solicitantes.update', $solicitante->id])) !!}
    {!! Form::hidden('id', $solicitante->id) !!}
    <div class="card-body">
        @include('solicitantes.form')
    </div>
    <div class="card-footer">
        {!! Form::submit('Alterar', ['class' => 'btn btn-primary']) !!}
        <a class="btn btn-danger" href="{{ route('solicitantes.index') }}">Cancelar</a>
    </div>
    {!! Form::close() !!}
</div>
@endsection
