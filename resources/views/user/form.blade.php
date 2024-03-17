<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="tipo">Tipo:</label>
            {!! Form::select('id_tipo', $tipos, isset($user) ? $user->id_tipo : null, ['placeholder' => 'Selecione o Tipo', 'class' => 'form-control', 'id' => 'tipo']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="name">Nome:</label>
            {!! Form::text('name', isset($user) ? $user->name : null, ['placeholder' => 'Nome', 'class' => 'form-control', 'id' => 'name']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="email">E-mail:</label>
            {!! Form::email('email', isset($user) ? $user->email : null, ['placeholder' => 'E-mail', 'class' => 'form-control', 'id' => 'email']) !!}
        </div>
    </div>
</div>
@if(empty($user))
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="senha">Senha:</label>
            {!! Form::password('password', ['placeholder' => Route::currentRouteName() == 'user.create' ? 'Senha' : 'Deixe em branco para não atualizar', 'class' => 'form-control', 'autocomplete' => 'off', 'id' => 'senha']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="confirma-password">Confirmar Senha:</label>
            {!! Form::password('password_confirmation', ['placeholder' => Route::currentRouteName() == 'user.create' ? 'Confirmar senha' : 'Deixe em branco para não atualizar', 'class' => 'form-control', 'id' => 'conforma-password']) !!}
        </div>
    </div>
</div>
@endif
@if(!empty($user))
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="status">Status</label>
            {!! Form::select('status', [1 => 'Ativo', 0 => 'Inativo'], ($user->status == 1) ? 1 : 0, ['class' => 'form-control', 'id' => 'status']) !!}
        </div>
    </div>
</div>
@endif

@section('scripts')
<script>
    $('#form_users').submit(function() {
        $(this).find('input[type=submit]').prop('disabled', true).attr('value', 'Aguarde...');
    });
</script>
@endsection
