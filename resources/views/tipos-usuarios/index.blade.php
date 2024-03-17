@extends('layouts.app')
@section('title', 'Usuários')

@section('content')
<div class="card mb-2">
    <div class="card-header">
        <h3>Tipos de Usuários</h3>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
            {{ session('success') }}
        </div>
        @endif
    </div>
    <div class="card-body">
        <form action="{{ route('user.index') }}" method="get" class="form-filter">
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="nome">Nome</label>
                    <div class="input-group">
                        <input type="text" name="nome" id="nome" class="form-control" value="{{ request('nome') }}" />
                        <div class="input-group-append">
                            <button class="btn btn-success"><i class="fa fa-search mr-2"></i><span>Pesquisar</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<section class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <th>ID</th>
            <th>Nome</th>
        </thead>
        <tbody>
            @if($tiposUsuarios->total() == 0)
            <tr>
                <th class="text-center" colspan="5">Nenhum Tipo de Usuário encontrado</th>
            </tr>
            @else
            @foreach ($tiposUsuarios as $tipo)
            <tr>
                <td>{{ $tipo->id }}</td>
                <td>{{ $tipo->nome }}</td>
              </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</section>

<section class="text-center">
    {{ $tiposUsuarios->appends(request()->query())->links() }}
    <h6><b>{{ $tiposUsuarios->total() }}</b> {{ $tiposUsuarios->total() == 1 ? 'registro' : 'registros' }} no total</h6>
</section>
@endsection


