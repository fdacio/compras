<div class="form">
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
                <label for="cnpj">CNPJ<small class="text-danger p-2">*</small></label>
                <div class="input-group">
                    {!! Form::text('cnpj', isset($empresa) ? $empresa->pessoa->pessoaJuridica->cnpj : null, [
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
                <label for="razao-social">Razão Social<small class="text-danger p-2">*</small></label>
                {!! Form::text('razao_social', isset($empresa) ? $empresa->pessoa->pessoaJuridica->razao_social : null, [
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
                {!! Form::text('cgf', isset($empresa) ? $empresa->pessoa->pessoaJuridica->cgf : null, [
                    'class' => 'form-control',
                    'id' => 'cgf',
                ]) !!}
            </div>
        </div>

        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <label for="nome-fantasia">Nome Fantasia<small class="text-danger p-2">*</small></label>
                {!! Form::text('nome_fantasia', isset($empresa) ? $empresa->pessoa->pessoaJuridica->nome_fantasia : null, [
                    'class' => 'form-control',
                    'id' => 'nome-fantasia',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label for="cep">CEP<small class="text-danger p-2">*</small></label>
                <div class="input-group">
                    {!! Form::text('cep', isset($empresa) ? $empresa->pessoa->cep : null, [
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
                <label for="logradouro">Logradouro<small class="text-danger p-2">*</small></label>
                {!! Form::text('logradouro', isset($empresa) ? $empresa->pessoa->logradouro : null, [
                    'class' => 'form-control',
                    'id' => 'logradouro',
                    'id' => 'logradouro',
                ]) !!}
            </div>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2">
            <div class="form-group">
                <label for="numero">Número<small class="text-danger p-2">*</small></label>
                {!! Form::text('numero', isset($empresa) ? $empresa->pessoa->numero : null, [
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
                {!! Form::text('complemento', isset($empresa) ? $empresa->pessoa->complemento : null, [
                    'class' => 'form-control',
                    'id' => 'complemento',
                ]) !!}
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label for="bairro">Bairro<small class="text-danger p-2">*</small></label>
                {!! Form::text('bairro', isset($empresa) ? $empresa->pessoa->bairro : null, [
                    'class' => 'form-control',
                    'id' => 'bairro',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label for="estado">UF<small class="text-danger p-2">*</small></label>
                {!! Form::select(
                    'estado',
                    $estados,
                    isset($empresa->pessoa->cidade->estado) ? $empresa->pessoa->cidade->estado->id : old('estado'),
                    ['placeholder' => 'Selecione', 'class' => 'form-control select', 'id' => 'estado'],
                ) !!}
            </div>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <label for="cidade">Cidade<small class="text-danger p-2">*</small></label>
                {!! Form::select(
                    'id_municipio',
                    $cidades,
                    isset($empresa->pessoa->cidade) ? $empresa->pessoa->cidade->id : old('id_municipio'),
                    ['placeholder' => 'Selecione um Estado', 'class' => 'form-control select', 'id' => 'cidade'],
                ) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label for="telefone">Telefone</label>
                {!! Form::tel('telefone', isset($empresa) ? $empresa->pessoa->telefone : null, [
                    'class' => 'form-control telefone',
                    'id' => 'telefone',
                ]) !!}
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label for="celular">Celular</label>
                {!! Form::tel('celular', isset($empresa) ? $empresa->pessoa->celular : null, [
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
                {!! Form::email('email', isset($empresa) ? $empresa->pessoa->email : null, [
                    'class' => 'form-control',
                    'id' => 'email',
                ]) !!}
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

            @if (!empty($empresa->pessoa->cidade))
                var estado = "@php echo $empresa->pessoa->cidade->estado->sigla @endphp";
                var cidade = "@php echo $empresa->pessoa->cidade->nome @endphp";
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
