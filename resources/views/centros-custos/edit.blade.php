@extends('layouts.app')
@section('title', 'Centro de Custo - Alterar')

@section('content')
<div class="card">
    <div class="card-header">
            <h2>Alterar Cadastro de Centro de Custo</h2>
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
    {!! Form::open(array('id' => 'form_centro_custo', 'method' => 'patch', 'route' => ['centros-custos.update', $centroCusto->id])) !!}
    {!! Form::hidden('id', $centroCusto->id) !!}
    <div class="card-body">
        @include('centros-custos.form')
    </div>
    <div class="card-footer">
        {!! Form::submit('Alterar', ['class' => 'btn btn-primary']) !!}
        <a class="btn btn-danger" href="{{ route('centros-custos.index') }}">Cancelar</a>
    </div>
    {!! Form::close() !!}
</div>
@endsection
