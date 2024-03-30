<div class="card-body">
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label for="id_frota">Frota<small class="text-danger p-2">*</small></label>
                {!! Form::select('id_frota', $frotas, isset($veiculo) ? $veiculo->id_frota : old('id_frota'), ['placeholder' => 'Selecione', 'class' => 'form-control select', 'id' => 'id_frota']) !!}
            </div>
        </div>        
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label for="id_empresa">Empresa<small class="text-danger p-2">*</small></label>
                {!! Form::select('id_empresa', $empresas, isset($veiculo) ? $veiculo->id_empresa : old('id_empresa'), ['placeholder' => 'Selecione', 'class' => 'form-control select', 'id' => 'id_empresa']) !!}
            </div>
        </div>        
        <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="form-group">
                <label for="id_centro_custo">Centro de Custo<small class="text-danger p-2">*</small></label>
                {!! Form::select('id_centro_custo', $centrosCustos, isset($veiculo) ? $veiculo->id_centro_custo : old('id_centro_custo'), ['placeholder' => 'Selecione', 'class' => 'form-control select', 'id' => 'id_centro_custo']) !!}
            </div>
        </div>        
    </div>  

    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label for="tipo">Tipo<small class="text-danger p-2">*</small></label>
                {!! Form::text('tipo', isset($veiculo->tipo) ? $veiculo->placa : old('tipo'), [
                    'class' => 'form-control',
                    'id' => 'tipo',
                ]) !!}
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label for="marca">Marca<small class="text-danger p-2">*</small></label>
                {!! Form::text('marca', isset($veiculo->marca) ? $veiculo->marca : old('marca'), [
                    'class' => 'form-control',
                    'id' => 'marca',
                ]) !!}
            </div>
        </div>        
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label for="modelo">Modelo<small class="text-danger p-2">*</small></label>
                {!! Form::text('modelo', isset($veiculo->modelo) ? $veiculo->modelo : old('modelo'), [
                    'class' => 'form-control',
                    'id' => 'modelo',
                ]) !!}
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label for="placa">Placa<small class="text-danger p-2">*</small></label>
                {!! Form::text('placa', isset($veiculo->placa) ? $veiculo->placa : old('placa'), [
                    'class' => 'form-control',
                    'id' => 'placa',
                ]) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label for="uf">UF<small class="text-danger p-2">*</small></label>
                {!! Form::text('uf', isset($veiculo->uf) ? $veiculo->uf : old('uf'), [
                    'class' => 'form-control',
                    'id' => 'uf',
                    'max-lenght' => 2
                ]) !!}
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label for="cor">Cor<small class="text-danger p-2">*</small></label>
                {!! Form::text('cor', isset($veiculo->cor) ? $veiculo->cor : old('cor'), [
                    'class' => 'form-control',
                    'id' => 'cor',
                ]) !!}
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label for="ano">Ano<small class="text-danger p-2">*</small></label>
                {!! Form::text('ano', isset($veiculo) ? $veiculo->ano : old('ano'), [
                    'class' => 'form-control ano',
                    'id' => 'ano',
                ]) !!}
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label for="renavan">Renavan</label>
                {!! Form::text('renavan', isset($veiculo->renavan) ? $veiculo->renavan : old('ranavan'), [
                    'class' => 'form-control',
                    'id' => 'renavan',
                ]) !!}
            </div>
        </div>
    </div>

</div>
