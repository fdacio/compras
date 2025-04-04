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
                <label for="cpf">CPF<small class="text-danger p-2">*</small></label>
                <div class="input-group">
                    {!! Form::text('cpf', isset($favorecido) ? $favorecido->pessoa->pessoaFisica->cpf : null, [
                        'class' => 'form-control cpf',
                        'id' => 'cpf',
                    ]) !!}
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary btn-cpf" type="button"><i
                                class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8">
            <div class="form-group">
                <label for="nome">Nome<small class="text-danger p-2">*</small></label>
                {!! Form::text('nome', isset($favorecido) ? $favorecido->pessoa->pessoaFisica->nome : null, [
                    'class' => 'form-control',
                    'id' => 'nome',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label for="rg">RG</label>
                {!! Form::text('rg', isset($favorecido) ? $favorecido->pessoa->pessoaFisica->rg : null, [
                    'class' => 'form-control',
                    'id' => 'rg',
                ]) !!}
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label for="rg-orgao">Órgão Emissor</label>
                {!! Form::text('rg_orgao', isset($favorecido) ? $favorecido->pessoa->pessoaFisica->rg_orgao : null, [
                    'class' => 'form-control',
                    'id' => 'rg-orgao',
                ]) !!}
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label for="rg-emissao">Emissão</label>
                {!! Form::text(
                    'rg_emissao',
                    isset($favorecido) ? \Carbon\Carbon::parse($favorecido->pessoa->pessoaFisica->rg_emissao)->format('d/m/Y') : null,
                    ['class' => 'form-control data', 'id' => 'rg-emissao'],
                ) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label for="nascimento">Nascimento</label>
                {!! Form::text(
                    'nascimento',
                    isset($favorecido) ? \Carbon\Carbon::parse($favorecido->pessoa->pessoaFisica->nascimento)->format('d/m/Y') : null,
                    ['class' => 'form-control data', 'id' => 'nascimento'],
                ) !!}
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label for="sexo">Sexo</label>
                {!! Form::select(
                    'sexo',
                    ['M' => 'Masculino', 'F' => 'Feminino'],
                    isset($favorecido) ? $favorecido->pessoa->pessoaFisica->sexo : old('sexo'),
                    ['class' => 'form-control data', 'id' => 'sexo'],
                ) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label for="cep">CEP<small class="text-danger p-2">*</small></label>
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
                <label for="logradouro">Logradouro<small class="text-danger p-2">*</small></label>
                {!! Form::text('logradouro', isset($favorecido) ? $favorecido->pessoa->logradouro : null, [
                    'class' => 'form-control',
                    'id' => 'logradouro',
                    'id' => 'logradouro',
                ]) !!}
            </div>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2">
            <div class="form-group">
                <label for="numero">Número<small class="text-danger p-2">*</small></label>
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
                <label for="bairro">Bairro<small class="text-danger p-2">*</small></label>
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
                <label for="estado">UF<small class="text-danger p-2">*</small></label>
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
                <label for="cidade">Cidade<small class="text-danger p-2">*</small></label>
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


@section('scripts')
    {!! Html::script('js/cpf.js') !!}
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
