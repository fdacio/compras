@extends('layouts.app')
@section('title', 'Autorização de Pagamento - Editar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Editar Autorização de Pagamento</h2>
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
            @if (session('success'))
                <div class="alert alert-success alert-dismissible ''">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span
                            aria-hidden="true">&times;</span></button>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('danger'))
                <div class="alert alert-danger alert-dismissible ''">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span
                            aria-hidden="true">&times;</span></button>
                    <strong>{{ session('danger') }}</strong>
                </div>
            @endif
            <div class="stepwizard" style="margin-top: 20px;">
                <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step">
                        <a href="{{ route('autorizacoes-pagamentos.edit', $autorizacao->id) }}"
                            class="btn btn-primary btn-circle"><i class="fa fa-file-text-o"></i></a>
                        <p><b>Cabeçalho da Autorização</b></p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="{{ route('autorizacoes-pagamentos.item.create', $autorizacao->id) }}"
                            class="btn btn-outline-secondary btn-light btn-circle"><i class="fa fa-list-ol"></i></a>
                        <p><b>Itens da Autorização</b></p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="{{ route('autorizacoes-pagamentos.documentos.create', $autorizacao->id) }}"
                            class="btn btn-outline-secondary btn-light btn-circle"><i class="fa fa-file-text-o"></i></a>
                        <p><b>Documentos da Autorização</b></p>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::open([
            'id' => 'form_autorizacao_pagamento',
            'method' => 'patch',
            'route' => ['autorizacoes-pagamentos.update', $autorizacao->id],
        ]) !!}
        {!! Form::hidden('id', $autorizacao->id) !!}
        <div class="card-body">
            @include('autorizacoes-pagamentos.form')
        </div>
        <div class="card-footer">
            {!! Form::submit('Alterar', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-danger" href="{{ route('autorizacoes-pagamentos.index') }}">Cancelar</a>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
@section('scripts')
    <script>
        $('.btn-cnpj-cpf').trigger('click');
    </script>
@endsection
