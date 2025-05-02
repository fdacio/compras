@extends('layouts.app')
@section('title', 'Cotação - Editar')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Editar Cotação Nº {{ $cotacao->id }}</h2>
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissable ''">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span
                            aria-hidden="true">&times;</span></button>
                    <small>Ops!</small> Verifique os erros.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="card-body">

            <!-- Requisição -->
            <div id="accordion-dadosRequisicao" class="accordion">
                <div class="card">
                    <div class="card-header border-0">
                        <a class="card-link" data-toggle="collapse" href="#dadosRequisicao">
                            Requisição Nº {{ $cotacao->requisicao->id }}
                        </a>
                    </div>
                    <div id="dadosRequisicao" class="collapse hide" data-parent="#accordion-dadosRequisicao">
                        <div class="card-body">
                            @include('cotacoes.dados-requisicao')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fornecedor -->
            <div class="card my-2">
                <div class="card-body">
                    {!! Form::open([
                        'id' => 'form_cotacao_fornecedor',
                        'method' => 'post',
                        'route' => ['cotacoes.fornecedor.store', $cotacao->id],
                    ]) !!}
                    <div class="form my-2">
                        <div class="row">
                            <div class="col-xs-10 col-sm-10 col-md-10">
                                <div class="form-group">
                                    <label for="fornecedor">Fornecedor</label>
                                    {!! Form::select('id_fornecedor', $fornecedores, old('id_fornecedor'), [
                                        'placeholder' => 'Selecione',
                                        'class' => 'form-control select',
                                        'id' => 'fornecedor',
                                    ]) !!}

                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    {!! Form::button('<i class="fa fa-plus mr-2"></i> Adicionar', [
                                        'type' => 'submit',
                                        'id' => 'btn-adicionar',
                                        'class' => 'btn btn-sm btn-primary form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- Fim do Fornecedor -->

            <!-- Itens-->
            {!! Form::open([
                'method' => 'put',
                'route' => ['cotacoes.update', $cotacao->id],
            ]) !!}
            @foreach ($cotacao->fornecedores as $item)
                <div class="card my-2">
                    <div class="card-header border-0">
                        <div class="row">
                            <div class="col-xs-11 col-sm-11 col-md-11">

                                <div id="accordion-itens-{{ $item->id }}" class="accordion">
                                    <a class="card-link" data-toggle="collapse" href="#itens-{{ $item->id }}">
                                        {{ $item->fornecedor->pessoa->nome_razao_social }}
                                    </a>
                                    <div id="itens-{{ $item->id }}" class="collapse hide"
                                        data-parent="#accordion-itens-{{ $item->id }}">
                                        <div class="card-body">
                                            <table class="table table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="col-xs-1 col-sm-1 col-md-1">Item</th>
                                                        <th class="col-xs-7 col-sm-7 col-md-7">Descrição</th>
                                                        <th class="col-xs-2 col-sm-2 col-md-2">Unidade</th>
                                                        <th class="col-xs-2 col-sm-2 col-md-2">Qtde.Solicitada</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($item->itens as $i)
                                                        <tr>
                                                            <td class="col-xs-1 col-sm-1 col-md-1">
                                                                {{ $i->item }}
                                                            </td>
                                                            <td class="col-xs-7 col-sm-7 col-md-7">
                                                                <div>{{ $i->descricao }}</div>
                                                                <div class="row">
                                                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="quantidade_cotada[{{ $i->id }}]" class="text-sm mb-1">Qtde.Cotada</label>
                                                                            <input
                                                                                type="text"
                                                                                name="quantidade_cotada[{{ $i->id }}]"
                                                                                id="quantidade_cotada[{{ $i->id }}]"
                                                                                class="form-control form-control-sm text-right quantidade"
                                                                                value="{{ $i->quantidade_cotada }}" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="quantidade_atendida[{{ $i->id }}]" class="text-sm mb-1">Qtde.Atendida</label>
                                                                            <input
                                                                                type="text"
                                                                                name="quantidade_atendida[{{ $i->id }}]"
                                                                                id="quantidade_atendida[{{ $i->id }}]"
                                                                                class="form-control form-control-sm text-right quantidade"
                                                                                value="{{ $i->quantidade_atendida }}" />
                                                                        </div>    
                                                                    </div>
                                                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="valor_unitario[{{ $i->id }}]" class="text-sm mb-1">Valor Unitário</label>
                                                                            <input
                                                                                type="text"
                                                                                name="valor_unitario[{{ $i->id }}]"
                                                                                id="valor_unitario[{{ $i->id }}]"
                                                                                class="form-control form-control-sm text-right real"
                                                                                value="{{ $i->valor_unitario }}" />
                                                                        </div>    
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="col-xs-2 col-sm-2 col-md-2">
                                                                {{ $i->unidade }}
                                                            </td>
                                                            <td class="text-right col-xs-2 col-sm-2 col-md-2">
                                                                {{ $i->quantidade_solicitada }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="text-center col-xs-1 col-sm-1 col-md-1">
                                {!! Form::open([
                                    'method' => 'delete',
                                    'route' => ['cotacoes.fornecedor.destroy', $cotacao->id],
                                    'style' => 'display:inline',
                                ]) !!}
                                {!! Form::hidden('id_cotacao_fornecedor', $item->id) !!}
                                {!! Form::button('<i class="fa fa-trash"></i>', [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm modal-excluir',
                                ]) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach 
            <div class="card-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
                        <a class="btn btn-danger" href="{{ route('cotacoes.index') }}">Cancelar</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <!-- Fim do Itens -->

        </div>
    </div>
@endsection
@if ($cotacao->fornecedores->count() > 0)
    @section('scripts')
        {!! Html::script('js/modal-excluir.js') !!}
    @endsection
@endif
