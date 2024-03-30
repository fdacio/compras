@extends('layouts.app')
@section('title', 'Veículos')

@section('content')
<div class="card mb-2">
    <div class="card-header">
        <h3>Veículos</h3>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
            {{ session('success') }}
        </div>
        @endif
        @if(session('danger'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
            {{ session('danger') }}
        </div>
        @endif
    </div>
    <div class="card-body">
        <form action="{{ route('veiculos.index') }}" method="get" class="form-filter">
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="placa">Placa</label>
                    <div class="input-group">
                        <input type="text" name="placa" id="placa" class="form-control placa" value="{{ request('placa') }}" />
                        <div class="input-group-append">
                            <button class="btn btn-success"><i class="fa fa-search mr-2"></i><span>Pesquisar</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <div class="text-right mb-2">
            <a href="{{ route('veiculos.create') }}" class="btn btn-primary"><i class="fa fa-plus mr-2"></i>Cadastrar</a>
        </div>
    </div>
</div>

<section class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <th class="col-md-1">ID</th>
            <th class="col-md-4">Placa</th>
            <th class="col-md-2">UF</th>
            <th class="col-md-2">Cor</th>
            <th class="col-md-2">Ano</th>
            <th class="col-md-1"></th>
        </thead>
        <tbody>
            @if ($veiculos->count() == 0)
                <tr>
                    <th class="text-center" colspan="7">Nenhum veículo cadastrado</th>
                </tr>
            @else
                @foreach ($veiculos as $veiculo)
                    <tr>
                        <td>{{ $veiculo->id }}</td>
                        <td>{{ $veiculo->placa }}</td>
                        <td>{{ $veiculo->uf }}</td>
                        <td>{{ $veiculo->cor }}</td>
                        <td>{{ $veiculo->ano }}</td>
                        <td class="text-right text-nowrap">
                            {!! Form::button('<i class="fa fa-edit"></i>', [
                                'class' => 'btn btn-primary btn-sm btn-edit-veiculo',
                                'data-id' => $veiculo->id,
                            ]) !!}
                            {!! Form::button('<i class="fa fa-trash"></i>', [
                                'class' => 'btn btn-danger btn-sm btn-delete-veiculo',
                                'data-id' => $veiculo->id,
                            ]) !!}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</section>

<section class="text-center">
    {{ $veiculos->appends(request()->query())->links() }}
    <h6><b>{{ $veiculos->total() }}</b> {{ $veiculos->total() == 1 ? 'registro' : 'registros' }} no total</h6>
</section>
@endsection

@if($veiculos->total() > 0)
@section('scripts')
{!! Html::script('js/modal-excluir.js') !!}
@endsection
@endif
