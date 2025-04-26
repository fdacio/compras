@extends('layouts.app')
@section('title', 'Usuários')

@section('content')
<div class="card mb-2">
    <div class="card-header">
        <h3>Usuários</h3>
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
    <div class="card-footer">
        <div class="text-right mb-2">
            <a href="{{ route('user.create') }}" class="btn btn-primary"><i class="fa fa-plus mr-2"></i>Cadastrar</a>
        </div>
    </div>
</div>
<section class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>e-Mail</th>
            <th>Tipo</th>
            <th>Status</th>
            <th style="width: 20%;"></th>
        </thead>
        <tbody>
            @if($users->total() == 0)
            <tr>
                <th class="text-center" colspan="5">Nenhum Usuário encontrado</th>
            </tr>
            @else
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->tipo->nome }}</td>
                <td>
                    @if ($user->status == 0)
                    <span class="text text-danger">Inativo</span>
                    @else
                    <span class="text text-success">Ativo</span>
                    @endif
                </td>
                <td class="text-right">
                    <a href="{{ route('user.show', $user->id) }}" class="btn btn-sm btn-info" title="Visualizar"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-pencil"></i></a>
                    <a href="{{ route('user.centros-custos.edit', $user->id) }}" class="btn btn-sm btn-success" title="Centros de Custos"><i class="fa fa-file-o"></i></a>
                    @if($users->total() > 0)
                    {!! Form::open(['id' => 'form_desativar_' . $user->id, 'method' => 'put', 'route' => ['user.desativar', $user->id], 'style'=>'display: inline']) !!}
                    {!! Form::button('<i class="fa fa-close"></i>', ['class' => 'btn btn-sm btn-danger modal-desativar-user', 'title' => 'Desativar']) !!}
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
    {{ $users->appends(request()->query())->links() }}
    <h6><b>{{ $users->total() }}</b> {{ $users->total() == 1 ? 'registro' : 'registros' }} no total</h6>
</section>
@endsection

@if($users->total() > 0)
@section('scripts')
{!! Html::script('js/modal-desativar-user.js') !!}
@endsection
@endif
