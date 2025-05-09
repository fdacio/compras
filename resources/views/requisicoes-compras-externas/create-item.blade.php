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
                        <a href="{{ route('requisicoes-compras-externas.edit', $requisicao->id) }}" class="btn  btn-outline-secondary btn-light btn-circle"><i
                                class="fa fa-file-text-o"></i></a>
                        <p><b>Cabeçalho da Requisição</b></p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="{{ route('requisicoes-compras-externas.item.create', $requisicao->id) }}"
                            class="btn btn-primary btn-circle"><i class="fa fa-list-ol"></i></a>
                        <p><b>Itens da Requisição</b></p>
                    </div>
                </div>
            </div>
    </div>
    {!! Form::open([
        'id' => 'form_requisicos_compras_item',
        'method' => 'post',
        'route' => ['requisicoes-compras-externas.item.store', $requisicao->id],
    ]) !!}
    {!! Form::hidden('id_requisicao', $requisicao->id) !!}
    <div class="card-body">
        @include('requisicoes-compras-externas.form-create-item')
    </div>
    {!! Form::close() !!}
</div>
@endsection
