<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" id="tabs-dados-favorecido-tab" data-toggle="pill" href="#tabs-dados-favorecido" role="tab"
            aria-controls="tabs-dados-favorecido" aria-selected="true">Dados do Favorecido</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="tabs-dados-bancarios-tab" data-toggle="pill" href="#tabs-dados-bancarios" role="tab"
            aria-controls="tabs-dados-bancarios" aria-selected="false">Dados Bancários</a>
    </li>
</ul>

<div class="tab-content" id="tabs-tabContent">
    <!-- Tab Dados do Favorecido -->
    <div class="tab-pane fade show active" id="tabs-dados-favorecido" role="tabpanel"
        aria-labelledby="tabs-dados-favorecido-tab">
        <div class="form card card-body" id="form-dados-favorecido">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <small class="text-danger">*Campos obrigatórios.</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label for="cnpj">CNPJ</label>
                        <div class="input-group">
                            {!! Form::text('cnpj', isset($favorecido) ? $favorecido->pessoa->pessoaJuridica->cnpj : null, [
                                'class' => 'form-control cnpj',
                                'id' => 'cnpj',
                            ]) !!}
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary btn-cnpj" type="button"><i
                                        class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8">
                    <div class="form-group">
                        <label for="razao-social">Razão Social</label>
                        {!! Form::text('razao_social', isset($favorecido) ? $favorecido->pessoa->pessoaJuridica->razao_social : null, [
                            'class' => 'form-control',
                            'id' => 'razao-social',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label for="cgf">CGF</label>
                        {!! Form::text('cgf', isset($favorecido) ? $favorecido->pessoa->pessoaJuridica->cgf : null, [
                            'class' => 'form-control',
                            'id' => 'cgf',
                        ]) !!}
                    </div>
                </div>

                <div class="col-xs-8 col-sm-8 col-md-8">
                    <div class="form-group">
                        <label for="nome-fantasia">Nome Fantasia</label>
                        {!! Form::text('nome_fantasia', isset($favorecido) ? $favorecido->pessoa->pessoaJuridica->nome_fantasia : null, [
                            'class' => 'form-control',
                            'id' => 'nome-fantasia',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 col-sm-3 col-md-3">
                    <div class="form-group">
                        <label for="cep">CEP</label>
                        <div class="input-group">
                            {!! Form::text('cep', isset($favorecido) ? $favorecido->pessoa->cep : null, [
                                'class' => 'form-control cep',
                                'id' => 'cep',
                            ]) !!}
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary btn-cep" type="button"><i
                                        class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-7 col-sm-7 col-md-7">
                    <div class="form-group">
                        <label for="logradouro">Logradouro</label>
                        {!! Form::text('logradouro', isset($favorecido) ? $favorecido->pessoa->logradouro : null, [
                            'class' => 'form-control',
                            'id' => 'logradouro',
                            'id' => 'logradouro',
                        ]) !!}
                    </div>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">
                        <label for="numero">Número</label>
                        {!! Form::text('numero', isset($favorecido) ? $favorecido->pessoa->numero : null, [
                            'class' => 'form-control',
                            'id' => 'numero',
                            'id' => 'numero',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        {!! Form::text('complemento', isset($favorecido) ? $favorecido->pessoa->complemento : null, [
                            'class' => 'form-control',
                            'id' => 'complemento',
                        ]) !!}
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="bairro">Bairro</label>
                        {!! Form::text('bairro', isset($favorecido) ? $favorecido->pessoa->bairro : null, [
                            'class' => 'form-control',
                            'id' => 'bairro',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label for="estado">UF</label>
                        {!! Form::select(
                            'estado',
                            $estados,
                            isset($favorecido->pessoa->cidade->estado) ? $favorecido->pessoa->cidade->estado->id : old('estado'),
                            ['placeholder' => 'Selecione', 'class' => 'form-control select', 'id' => 'estado'],
                        ) !!}
                    </div>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8">
                    <div class="form-group">
                        <label for="cidade">Cidade</label>
                        {!! Form::select(
                            'id_municipio',
                            $cidades,
                            isset($favorecido->pessoa->cidade) ? $favorecido->pessoa->cidade->id : old('id_municipio'),
                            ['placeholder' => 'Selecione um Estado', 'class' => 'form-control select', 'id' => 'cidade'],
                        ) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        {!! Form::tel('telefone', isset($favorecido) ? $favorecido->pessoa->telefone : null, [
                            'class' => 'form-control telefone',
                            'id' => 'telefone',
                        ]) !!}
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="celular">Celular</label>
                        {!! Form::tel('celular', isset($favorecido) ? $favorecido->pessoa->celular : null, [
                            'class' => 'form-control celular',
                            'id' => 'celular',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        {!! Form::email('email', isset($favorecido) ? $favorecido->pessoa->email : null, [
                            'class' => 'form-control',
                            'id' => 'email',
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tab Dados Bancários -->
    <div class="tab-pane fade" id="tabs-dados-bancarios" role="tabpanel" aria-labelledby="tabs-dados-bancarios-tab">
        <div class="form card card-body">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="banco">Banco</label>
                        {!! Form::tel('banco', isset($favorecido) ? $favorecido->banco : null, [
                            'class' => 'form-control banco',
                            'id' => 'banco',
                        ]) !!}
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">    
                    <div class="form-group">
                        <label for="agencia">Agência</label>
                        {!! Form::text('agencia', isset($favorecido) ? $favorecido->agencia : null, [
                            'class' => 'form-control',
                            'id' => 'agencia',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="conta">Conta</label>
                        {!! Form::text('conta', isset($favorecido) ? $favorecido->conta : null, [
                            'class' => 'form-control',
                            'id' => 'conta',
                        ]) !!}
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="operacao">Operação</label>
                        {!! Form::text('operacao', isset($favorecido) ? $favorecido->operacao : null, [
                            'class' => 'form-control',
                            'id' => 'operacao',
                        ]) !!}

                    </div>
                </div>
            </div>
            <div class="row">    
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="chave_pix">Chave PIX</label>
                        {!! Form::text('operacao', isset($favorecido) ? $favorecido->chave_pix : null, [
                            'class' => 'form-control',
                            'id' => 'chave_pix',
                        ]) !!}
                    </div>
                </div>               
            </div>
        </div>               
    </div>
</div>        

@section('scripts')
    {!! Html::script('js/cnpj.js') !!}
    {!! Html::script('js/cep.js') !!}
    {!! Html::script('js/cidades.js') !!}
    <script>
        $(document).ready(function() {

            @if (!empty($favorecido->pessoa->cidade))
                var estado = "@php echo $favorecido->pessoa->cidade->estado->sigla @endphp";
                var cidade = "@php echo $favorecido->pessoa->cidade->nome @endphp";
                setEstado(estado, cidade);
            @endif

            @if (!empty(old('id_municipio')))
                var estado = $("#estado option:selected").text();
                var idCidade = @php echo old('id_municipio') @endphp;
                setEstadoCidadeId(estado, idCidade);
            @endif

        });
    </script>
@endsection
