@extends('layouts.app')
@section('title', 'Autorização de Pagamento - Cadastrar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Cadastrar Autorização de Pagamento</h3>
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
        {!! Form::open(['id' => 'form_autorizacao_pagamento', 'method' => 'post', 'route' => 'autorizacoes-pagamentos.store']) !!}
        <div class="card-body">
            @include('autorizacoes-pagamentos.form')
        </div>
        <div class="card-footer">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-danger" href="{{ route('autorizacoes-pagamentos.index') }}">Cancelar</a>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
