@extends('layouts.app')
@section('title', 'Favorecidos')

@section('content')
    <div class="card mb-2">
        <div class="card-header">
            <h3>Favorecidos</h3>
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
            <form action="{{ route('favorecidos.index') }}" method="get" class="form-filter">
                <div class="row">
                    <div class="col-md-2">
                        <label for="pessoa">Pessoa</label>
                        {!! Form::select('pessoa', ['PF' => 'Física', 'PJ' => 'Jurídica'],  request('pessoa'), ['class' => 'form-control', 'id' => 'pessoa']) !!}
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cpf-cnpj" id="label-cpf-cnpj">CNPJ</label>
                            <input type="text" name="cpf_cnpj" id="cpf-cnpj" class="form-control"
                                value="{{ request('cpf_cnpj') }}" />
                        </div>
                    </div>
                    <div class="form-group col-md-7">
                        <label for="nome-razao-social" id="label-nome-razao-social">Razão Social</label>
                        <div class="input-group">
                            <input type="text" name="nome_razao_social" id="nome-razao-social" class="form-control"
                                value="{{ request('nome_razao_social') }}" />
                            <div class="input-group-append">
                                <button class="btn btn-success"><i
                                        class="fa fa-search mr-2"></i><span>Pesquisar</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="text-right mb-2">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-plus mr-2"></i>Cadastrar
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="{{ route('favorecidos.create') }}" class="dropdown-item">Pessoa Jurídica</a>
                        <a href="{{ route('favorecidos.pessoa.fisica.create') }}" class="dropdown-item">Pessoa
                            Física</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="table-responsive">

        <table class="table table-striped table-hover">
            <thead>
                <th style="width: 5%;">ID</th>
                <th style="width: 20%;">CNPJ/CPF</th>
                <th style="width: 55%;">Razão Social/Nome</th>
                <th style="width: 20%;"></th>
            </thead>
            <tbody>
                @if ($favorecidos->total() == 0)
                    <tr>
                        <th class="text-center" colspan="6">Nenhum favorecido encontrado</th>
                    </tr>
                @else
                    @foreach ($favorecidos as $favorecido)
                        <tr>
                            <td>{{ $favorecido->id }}</td>
                            <td>{{ Formatter::cpfCnpj($favorecido->pessoa->cpf_cnpj) }}</td>
                            <td>{{ $favorecido->pessoa->nome_razao_social }}</td>
                            <td class="text-right text-nowrap">
                                <a href="{{ route('favorecidos.show', $favorecido->id) }}" class="btn btn-info"
                                    title="Visualizar"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('favorecidos.edit', $favorecido->id) }}" class="btn btn-primary"
                                    title="Editar"><i class="fa fa-pencil"></i></a>
                                @if ($favorecidos->total() > 0)
                                    {!! Form::open(['id' => 'form_excluir_' . $favorecido->id, 'method' => 'delete', 'route' => ['favorecido.destroy', $favorecido->id], 'style' => 'display: inline']) !!}
                                    {!! Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger modal-excluir']) !!}
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
        {{ $favorecidos->appends(request()->query())->links() }}
        <h6><b>{{ $favorecidos->total() }}</b> {{ $favorecidos->total() == 1 ? 'registro' : 'registros' }} no total
        </h6>
    </section>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {

            var changeMask = function() {
                var pessoa = $('#pessoa').val().toString();
                if (pessoa === "PJ") {
                    $('#label-cpf-cnpj').html('CNPJ');
                    $('#label-nome-razao-social').html('Razão Social');
                    $('#cpf-cnpj').mask('99.999.999/9999-99').trigger('mask');;
                }
                if (pessoa === "PF") {
                    $('#label-cpf-cnpj').html('CPF');
                    $('#label-nome-razao-social').html('Nome');
                    $('#cpf-cnpj').mask('999.999.999-99').trigger('mask');;
                }
            }

            changeMask();

            $('#pessoa').on('change', function() {
                changeMask();
            });

        });
    </script>

        @if ($favorecidos->total() > 0)
            {!! Html::script('js/modal-excluir.js') !!}
        @endif


@endsection
