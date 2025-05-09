@extends('layouts.app')
@section('title', 'Autorizações de Pagamentos')

@section('content')
    <div class="card mb-2">
        <div class="card-header">
            <h3>Autorizações de Pagamentos</h3>
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
            <form action="{{ route('autorizacoes-pagamentos.index') }}" method="get" class="form-filter">
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <div class="form-group">
                            <label for="pessoa">Pessoa</label>
                            {!! Form::select('pessoa', ['PF' => 'Física', 'PJ' => 'Jurídica'], request('pessoa'), [
                                'class' => 'form-control',
                                'id' => 'pessoa',
                                'value' => 'PF',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <label for="cnpj-cpf">CPF Favorecido</label>
                            <div class="input-group">
                                {!! Form::text('cnpj_cpf', request('cnpj_cpf'), ['class' => 'form-control cpf', 'id' => 'cnpj-cpf']) !!}
                                {!! Form::hidden('id_favorecido', request('id_favorecido'), ['id' => 'id_favorecido']) !!}
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary btn-cnpj-cpf" type="button"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <span class="text text-danger"></span>
                        </div>
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5">
                        <div class="form-group">
                            <label for="razao-social-nome">Nome Favorecido<small class="text-danger p-2">*</small></label>
                            {!! Form::text('razao_social_nome', request('razao_social_nome'), [
                                'class' => 'form-control',
                                'id' => 'razao-social-nome',
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label>&nbsp;</label>
                        <button class="btn btn-success form-control"><i
                                class="fa fa-search mr-2"></i><span>Pesquisar</span></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="text-right mb-2">
                <a href="{{ route('autorizacoes-pagamentos.create') }}" class="btn btn-primary"><i
                        class="fa fa-plus mr-2"></i>Cadastrar</a>
            </div>
        </div>
    </div>
    <section class="table-responsive">

        <table class="table table-striped table-hover">
            <thead>
                <th>Código</th>
                <th>Data</th>
                <th>Favorecido</th>
                <th>Valor</th>
                <th>Situação</th>
                <th style="width: 15%;"></th>
            </thead>
            <tbody>
                @if ($autorizacoes->total() == 0)
                    <tr>
                        <th class="text-center" colspan="6">Nenhuma autorização encontrada</th>
                    </tr>
                @else
                    @foreach ($autorizacoes as $autorizacao)
                        <tr>
                            <td>{{ $autorizacao->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($autorizacao->data)->format('d/m/Y') }}</td>
                            <td>{{ Formatter::cpfCnpj($autorizacao->favorecido->pessoa->cpf_cnpj) . ' - ' . $autorizacao->favorecido->pessoa->nome_razao_social }}
                            </td>
                            <td class="text-nowrap text-right">{{ 'R$ ' . number_format($autorizacao->valor, 2, ',', '.') }}</td>
                            <td>{{ $autorizacao->situacao_nome }}</td>
                            <td class="text-right text-nowrap">

                                <a href="{{ route('autorizacoes-pagamentos.show', $autorizacao->id) }}"
                                    class="btn btn-info btn-sm" title="Visualizar"><i class="fa fa-eye"></i></a>

                                <a href="{{ route('autorizacoes-pagamentos.edit', $autorizacao->id) }}"
                                    class="btn btn-primary btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>

                                @if ($autorizacoes->total() > 0)
                                    {!! Form::open([
                                        'id' => 'form_autorizar_' . $autorizacao->id,
                                        'method' => 'put',
                                        'route' => ['autorizacoes-pagamentos.autorizar', $autorizacao->id],
                                        'style' => 'display: inline',
                                    ]) !!}
                                    {!! Form::button('<i class="fa fa-check"></i>', ['class' => 'btn btn-success btn-sm modal-autorizar', 'title' => 'Autorizar']) !!}
                                    {!! Form::close() !!}
                                @endif

                                @if ($autorizacoes->total() > 0)
                                    {!! Form::open([
                                        'id' => 'form_excluir_' . $autorizacao->id,
                                        'method' => 'delete',
                                        'route' => ['autorizacoes-pagamentos.destroy', $autorizacao->id],
                                        'style' => 'display: inline',
                                    ]) !!}
                                    {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger btn-sm modal-excluir', 'title' => 'Excluir']) !!}
                                    {!! Form::close() !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </section>

    <section class="text-center">
        {{ $autorizacoes->appends(request()->query())->links() }}
        <h6><b>{{ $autorizacoes->total() }}</b> {{ $autorizacoes->total() == 1 ? 'registro' : 'registros' }} no total</h6>
    </section>
@endsection

@if ($autorizacoes->total() > 0)
    @section('scripts')
        {!! Html::script('js/modal-excluir.js') !!}
        {!! Html::script('js/modal-autorizar.js') !!}
    @endsection
@endif

@section('scripts')
    <script>
        $('#pessoa').on('change', function() {
            setCnpjCpfFavorecido($(this).val());
        });

        function setCnpjCpfFavorecido(tipo) {
            if (tipo == 'PJ') {
                $('#cnpj-cpf').mask('99.999.999/9999-99').trigger('mask');
                $('label[for="cnpj-cpf"]').html('CNPJ Favorecido');
                $('label[for="razao-social-nome"]').html('Razão Social Favorecido');
            } else if (tipo == 'PF') {
                $('#cnpj-cpf').mask('999.999.999-99').trigger('mask');
                $('label[for="cnpj-cpf"]').html('CPF Favorecido');
                $('label[for="razao-social-nome"]').html('Nome Favorecido');
            }
        }
        setCnpjCpfFavorecido($('#pessoa').val());
    </script>
    {!! Html::script('js/favorecidos.js') !!}
@endsection
