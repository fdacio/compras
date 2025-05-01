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
                    <strong>Ops!</strong> Verifique os erros.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="card-body">
            <div id="accordion-dadosRequisicao" class="accordion">
                <div class="card">
                    <div class="card-header border-0">
                        <a class="card-link" data-toggle="collapse" href="#dadosRequisicao">
                            Requisição Nº {{ $cotacao->requisicao->id }}
                        </a>
                    </div>
                    <div id="dadosRequisicao" class="collapse hide" data-parent="#accordion-dadosRequisicao">
                        <div class="card-body">
                            @include('cotacoes.dados-requisicao');
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::open([
                'id' => 'form_cotacao_fornecedor',
                'method' => 'post',
                'route' => ['cotacoes.fornecedor.store', $cotacao->id]
            ]) !!}
            <div class="form my-2">
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-md-10">
                        <div class="form-group">
                            <label for="fornecedor">Fornecedor</label>
                            {!! Form::select(
                                'id_fornecedor',
                                $fornecedores,
                                old('id_fornecedor'),
                                [
                                    'placeholder' => 'Selecione',
                                    'class' => 'form-control select', 
                                    'id' => 'fornecedor'
                                ],
                            ) !!}

                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            {!! Form::button('<i class="fa fa-plus mr-2"></i> Adicionar', [
                                'type' => 'submit',
                                'id' => 'btn-adicionar',
                                'class' => 'btn btn-primary form-control',
                            ]) !!}
                            </div>
                    </div>        
                </div>

            </div>
            {!! Form::close() !!}
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered table-hover" id="tabela_cotacao_fornecedor">
                    <tbody>
                        @foreach ($cotacao->fornecedores as $item)
                            <tr>
                                <td>
                                    {{ $item->fornecedor->pessoa->nome_razao_social }}

                                    <div id="accordion-itens-{{ $item->id}}" class="accordion">
                                        <div class="card-header border-0">
                                            <a class="card-link" data-toggle="collapse"
                                                href="#itens-{{ $item->id}}">
                                                Itens
                                            </a>
                                        </div>
                                        <div id="itens-{{ $item->id}}" class="collapse hide"
                                            data-parent="#accordion-itens-{{ $item->id}}">
                                            <div class="card-body">
                                                @foreach ($item->itens as $i)   
                                                {{$i->item .'-'. $i->descricao}}
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    {!! Form::open([
                                        'method' => 'delete',
                                        'route' => ['cotacoes.fornecedor.destroy', $cotacao->id],
                                        'style' => 'display:inline'
                                    ]) !!}
                                    {!! Form::hidden('id_cotacao_fornecedor', $item->id) !!}
                                    {!! Form::button('<i class="fa fa-trash"></i>', [
                                        'type' => 'submit',
                                        'class' => 'btn btn-danger btn-sm',
                                    ]) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

        </div>
    </div>
@endsection
