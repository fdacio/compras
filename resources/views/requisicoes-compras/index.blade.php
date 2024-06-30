@extends('layouts.app')
@section('title', 'Requisições de Compras')

@section('content')
    <div class="card mb-2">
        <div class="card-header">
            <h3>Requisições de Compras</h3>
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
        <div class="card-body">
            <form action="{{ route('requisicoes-compras.index') }}" method="get" class="form-filter">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="id-requisitante">Requisitante</label>
                        <div class="input-group">
                            {!! Form::select('id_requisitante', $requisitantes, request('id_requisitante'), [
                                'placeholder' => 'Todos',
                                'class' => 'form-control select',
                                'id' => 'id_requisitante',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="id-solicitante">Solicitante</label>
                        <div class="input-group">
                            {!! Form::select('id_solicitante', $solicitantes, request('id_solicitante'), [
                                'placeholder' => 'Todos',
                                'class' => 'form-control select',
                                'id' => 'id_solicitante',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="id-veiculo">Veículo</label>
                        <div class="input-group">
                            {!! Form::select('id_veiculo', $veiculos, request('id_veiculo'),
                                ['placeholder' => 'Todos', 
                                'class' => 'form-control select', 
                                'id' => 'id_veiculo'],
                            ) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 text-right">
                        <button class="btn btn-success"><i
                            class="fa fa-search mr-2"></i><span>Pesquisar</span></button>

                    </div>
                </div>    
            </form>
        </div>
        <div class="card-footer">
            <div class="text-right mb-2">
                <a href="{{ route('requisicoes-compras.create') }}" class="btn btn-primary"><i
                        class="fa fa-plus mr-2"></i>Cadastrar</a>
            </div>
        </div>
    </div>
@endsection