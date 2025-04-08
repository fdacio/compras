@extends('layouts.app')
@section('title', 'Requisição de Compras - Editar')

@section('content')
<div class="card">
    <div class="card-header">
            <h2>Editar Requisição de Compra</h2>
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
                        <a href="{{ route('requisicoes-compras.edit', $requisicao->id) }}" class="btn btn-primary btn-circle"><i
                                class="fa fa-file-text-o"></i></a>
                        <p><b>Cabeçalho da Requisição</b></p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="{{ route('requisicoes-compras.item.create', $requisicao->id) }}"
                            class="btn btn-outline-secondary btn-light btn-circle"><i class="fa fa-list-ol"></i></a>
                        <p><b>Itens da Requisição</b></p>
                    </div>
                </div>
            </div>
    </div>
    {!! Form::open(array('id' => 'form_requisicao_compra', 'method' => 'patch', 'route' => ['requisicoes-compras.update', $requisicao->id])) !!}
    {!! Form::hidden('id', $requisicao->id) !!}
    <div class="card-body">
        @include('requisicoes-compras.form')
    </div>
    <div class="card-footer">
        {!! Form::submit('Alterar', ['class' => 'btn btn-primary']) !!}
        <a class="btn btn-danger" href="{{ route('requisicoes-compras.index') }}">Cancelar</a>
        <a href="{{ route('requisicoes-compras.gera.pdf', $requisicao->id) }}" class="btn btn-success" title="download"
            target="_blank">Demonstrativo</a>

    </div>
    {!! Form::close() !!}
</div>
@endsection
