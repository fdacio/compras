@extends('layouts.app')
@section('title', 'Fornecedor - Alterar')

@section('content')
<div class="card">
    <div class="card-header">
            <h2>Alterar Cadastro de Favorecido - Pessoa Física</h2>
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
    {!! Form::open(array('id' => 'form_favorecidos', 'method' => 'patch', 'route' => ['fornecedores.pessoa.fisica.update', $fornecedor->id], 'enctype' => 'multipart/form-data')) !!}
    {!! Form::hidden('id', $fornecedor->id) !!}
    <div class="card-body">
        @include('fornecedores.pessoas-fisicas.form')
    </div>
    <div class="card-footer">
        {!! Form::submit('Alterar', ['class' => 'btn btn-primary']) !!}
        <a class="btn btn-danger" href="{{ route('fornecedores.index') }}">Cancelar</a>
    </div>
    {!! Form::close() !!}
</div>
@endsection
