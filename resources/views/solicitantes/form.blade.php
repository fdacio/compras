<div class="form">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="nome">Nome</label>
                {!! Form::text('nome', isset($solicitante) ? $solicitante->nome : null, ['class' => 'form-control', 'id' => 'nome']) !!}
            </div>
        </div>
    </div>
</div>
