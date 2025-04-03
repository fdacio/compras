<div id="step1" class="setup-content">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <small class="text-danger">*Campos obrigatórios.</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-2 col-sm-2 col-md-2">
            <div class="form-group">
                <label for="pessoa">Pessoa</label>
                {!! Form::select('pessoa', ['PJ' => 'Jurídica', 'PF' => 'Física'], isset($autorizacao) ? $autorizacao->favorecido->pessoa->tipo : old('pessoa'), ['class' => 'form-control', 'id' => 'pessoa', 'value' => 'PJ']) !!}
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label for="cnpj-cpf">CNPJ Favorecido<small class="text-danger p-2">*</small></label>
                <div class="input-group">
                    {!! Form::text('cnpj_cpf', isset($autorizacao) ? $autorizacao->favorecido->pessoa->cpf_cnpj : old('cnpj_cpf'), ['class' => 'form-control', 'id' => 'cnpj-cpf']) !!}
                    {!! Form::hidden('id_favorecido', isset($autorizacao) ? $autorizacao->favorecido->id : old('id_favorecido'), ['id' => 'id_favorecido']) !!}
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary btn-cnpj-cpf" type="button"><i
                                class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-7 col-sm-7 col-md-7">
            <div class="form-group">
                <label for="favorecidos" >Razão Social Favorecido<small class="text-danger p-2">*</small></label>
                {!! Form::select(
                    'favorecidos', 
                    $favorecidos, 
                    isset($autorizacao) ? $autorizacao->id_favorecido : 
                    old('id_favorecido'), 
                    ['class' => 'form-control', 'id' => 'favorecidos']) 
                !!}
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="municipio">Município<small class="text-danger p-2">*</small></label>
                {!! Form::select(
                    'id_municipio', 
                    $municipios, 
                    isset($autorizacao) ? $autorizacao->id_municipio : old('id_municipio'), 
                    ['placeholder' => 'Selecione', 'class' => 'form-control select', 'id' => 'municipio']) 
                !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="id_veiculo">Veículo<small class="text-danger p-2">*</small></label>
                {!! Form::select(
                    'id_veiculo',
                    $veiculos,
                    isset($requisicao) ? $requisicao->id_veiculo : old('id_veiculo'),
                    ['placeholder' => 'Selecione', 'class' => 'form-control select', 'id' => 'id_veiculo'],
                ) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <label for="forma-pagamento">Forma de Pagamento<small class="text-danger p-2">*</small></label>
                {!! Form::select('id_forma_pagamento', $formasPagamentos, isset($autorizacao) ? $autorizacao->id_forma_pagamento : old('id_forma_pagamento'), ['placeholder' => 'Selecione', 'class' => 'form-control select', 'id' => 'forma-pagamento']) !!}
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label for="valor">Valor<small class="text-danger p-2">*</small></label>
                {!! Form::text('valor', isset($autorizacao) ? $autorizacao->valor : old('valor'), ['id' => 'valor', 'maxlength' => '21', 'class' => 'form-control real text-right']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label for="banco">Banco</label>
                {!! Form::text('banco', isset($autorizacao) ? $autorizacao->banco : old('banco'), ['class' => 'form-control', 'id' => 'banco']) !!}
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label for="agencia">Agência</label>
                {!! Form::text('agencia', isset($autorizacao) ? $autorizacao->agencia : old('agencia'), ['class' => 'form-control', 'id' => 'agencia']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label for="conta">Conta</label>
                {!! Form::text('conta', isset($autorizacao) ? $autorizacao->conta : old('conta'), ['class' => 'form-control', 'id' => 'conta']) !!}
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label for="operacao">Operação</label>
                {!! Form::text('operacao', isset($autorizacao) ? $autorizacao->operacao : old('operacao'), ['class' => 'form-control', 'id' => 'operacao']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="chave-pix">Chave PIX</label>
                {!! Form::text('chave_pix', isset($autorizacao) ? $autorizacao->chave_pix : old('chave_pix'), ['class' => 'form-control', 'id' => 'chave-pix']) !!}
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="observacao">Observação</label>
                {!! Form::textarea('observacao', isset($autorizacao) ? $autorizacao->observacao : old('observacao'), ['class' => 'form-control', 'id' => 'observacao']) !!}
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $('#form_contaspagar').submit(function() {
            $(this).find('input[type=submit]').prop('disabled', true).attr('value', 'Aguarde...');
        });

        @if (!empty(old('pessoa')))
            $('#pessoa').val('@php echo old('pessoa') @endphp');
        @endif

        @if (!empty($autorizacao))
            $('#pessoa').val('@php echo $autorizacao->favorecido->pessoa->tipo_pessoa @endphp');
        @endif

        $('#pessoa').on('change', function() {
            setCnpjCpffavorecido($(this).val());
        });

        function setCnpjCpffavorecido(tipo) {
            if (tipo == 'PJ') {
                $('#cnpj-cpf').mask('99.999.999/9999-99').trigger('keyup');
                $('label[for="cnpj-cpf"]').html('CNPJ Favorecido<small class="text-danger p-2">*</small>');
                $('label[for="favorecidos"]').html('Razão Social Favorecido');
            } else if (tipo == 'PF') {
                $('#cnpj-cpf').mask('999.999.999-99').trigger('keyup');
                $('label[for="cnpj-cpf"]').html('CPF Favorecido<small class="text-danger p-2">*</small>');
                $('label[for="favorecidos"]').html('Nome Favorecido');
            }
        }
        setCnpjCpffavorecido($('#pessoa').val());

    </script>

    {!! Html::script('js/favorecidos.js') !!}

@endsection
