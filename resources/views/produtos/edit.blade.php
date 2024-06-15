@extends('layouts.app')
@section('title', 'Produtos - Alterar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Alterar Cadastro de Produto</h2>
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
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span
                            aria-hidden="true">&times;</span></button>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('danger'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span
                            aria-hidden="true">&times;</span></button>
                    {{ session('danger') }}
                </div>
            @endif
        </div>
        {!! Form::open(['id' => 'form_produtos', 'method' => 'patch', 'route' => ['produtos.update', $produto->id], 'enctype' => 'multipart/form-data']) !!}
        {!! Form::hidden('id', $produto->id) !!}
        <div class="card-body">
            @include('produtos.form')
        </div>
        <div class="card-footer">
            {!! Form::submit('Alterar', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-danger" href="{{ route('produtos.index') }}">Cancelar</a>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
