@extends('layouts.app')
@section('title', 'Requisição de Compra - Cotação')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Requisição de Compra - Cotação</h2>
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
            <div id="accordion-dadosRequisicao">
                <div class="card">
                    <div class="card-header border-0">
                        <a class="card-link" data-toggle="collapse" href="#dadosRequisicao">
                            Requisição Nº {{ $cotacao->requisicao->id }}
                        </a>
                    </div>
                    <div id="dadosRequisicao" class="collapse hide" data-parent="#accordion-dadosRequisicao">
                        <div class="card-body">
                            <table class="table-sm">
                                <tr>
                                    <th class="col-md-3">Data da Requisição:</th>
                                    <td>{{ \Carbon\Carbon::parse($cotacao->requisicao->data)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="col-md-3">Tipo da Requisição:</th>
                                    <td>{{ $cotacao->requisicao->tipo_nome }}</td>
                                </tr>
                                <tr>
                                    <th class="col-md-3">Contrato da Requisição:</th>
                                    <td>{{ $cotacao->requisicao->empresa->pessoa->nome_razao_social }}</td>
                                </tr>
                                <tr>
                                    <th class="col-md-3">Centro de Custo:</th>
                                    <td>{{ $cotacao->requisicao->requisitante->nome }}</td>
                                </tr>
                                <tr>
                                    <th class="col-md-3">Solicitante:</th>
                                    <td>{{ $cotacao->requisicao->solicitante->nome }}</td>
                                </tr>
                                <tr>
                                    <th class="col-md-3">Veículo:</th>
                                    <td>{{ $cotacao->requisicao->veiculo ? $cotacao->requisicao->veiculo->placa . ' - ' . $cotacao->requisicao->veiculo->marca . ' - ' . $cotacao->requisicao->veiculo->modelo : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="col-md-3">Local de entrega:</th>
                                    <td>
                                        <p style="white-space: pre-wrap">{{ $cotacao->requisicao->local_entrega }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="col-md-3">Situação:</th>
                                    <td>{{ $cotacao->requisicao->situacao_nome }}</td>
                                </tr>
                                @if ($cotacao->requisicao->situacao == \App\RequisicaoCompra::SITUACAO_AUTORIZADO)
                                    <tr>
                                        <th class="col-md-3">Usuário Autorizador:</th>
                                        <td>{{ $cotacao->requisicao->usuarioAutorizacao ? $requisicao->usuarioAutorizacao->name : 'Usuário não cadastrado' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3">Data da Autorização:</th>
                                        <td>{{ $cotacao->requisicao->data_autorizacao ? \Carbon\Carbon::parse($requisicao->data_autorizacao)->format('d/m/Y') : '' }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <th class="col-md-3">Observação:</th>
                                    <td>
                                        <p style="white-space: pre-wrap">{{ $cotacao->requisicao->obsrvacao }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="col-md-3">Urgente:</th>
                                    <td>{{ $cotacao->requisicao->urgente ? 'Sim' : 'Não' }}</td>
                                </tr>
                                <tr>
                                    <th>Usuário que Cadastrou:</th>
                                    <td>{{ $cotacao->requisicao->usuarioCadastrou ? $cotacao->requisicao->usuarioCadastrou->name : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Criado:</th>
                                    <td>{{ \Carbon\Carbon::parse($cotacao->requisicao->created_at)->format('d/m/Y H:i:s') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Usuário que Alterou:</th>
                                    <td>{{ $cotacao->requisicao->usuarioAlterou ? $cotacao->requisicao->usuarioAlterou->name : '' }}
                                    </td>
                                <tr>
                                    <th>Alterado:</th>
                                    <td>{{ \Carbon\Carbon::parse($cotacao->requisicao->updated_at)->format('d/m/Y H:i:s') }}
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::open([
                'id' => 'form_cotacao_fornecedor',
                'method' => 'post',
                'route' => ['cotacoes.fornecedor.store', $cotacao->id]
            ]) !!}
            <div class="form mt-2">
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
                <table class="table table-striped table-bordered table-hover" id="tabela_cotacao_fornecedor">
                    <thead>
                        <tr>
                            <th>Fornecedor</th>
                            <th>Data</th>
                            <th>Valor Total</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cotacao->fornecedores as $item)
                            <tr>
                                <td>{{ $item->fornecedor->pessoa->nome_razao_social }}</td>
                                <td class="text-center">
                                    {!! Form::open([
                                        'method' => 'delete',
                                        'route' => ['cotacoes.fornecedor.destroy', $item->id],
                                        'style' => 'display:inline'
                                    ]) !!}
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
