<div class="form">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <small class="text-danger">*Campos obrigatórios.</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label for="tipo">Tipo<small class="text-danger p-2">*</small></label>
                {!! Form::select(
                    'tipo',
                    $tipos,
                    isset($requisicao) ? $requisicao->tipo : old('tipo'),
                    ['placeholder' => 'Selecione', 'class' => 'form-control select', 'id' => 'tipo'],
                ) !!}
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="id_requisitante">Requisitante<small class="text-danger p-2">*</small></label>
                {!! Form::select('id_requisitante', $requisitantes, isset($requisicao) ? $requisicao->id_requisitante : old('id_requisitante'), [
                    'placeholder' => 'Selecione',
                    'class' => 'form-control select',
                    'id' => 'id_requisitante',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="id_solicitante">Solicitante<small class="text-danger p-2">*</small></label>
                {!! Form::select('id_solicitante', $solicitantes, isset($requisicao) ? $requisicao->id_solicitante : old('id_solicitante'), [
                    'placeholder' => 'Selecione',
                    'class' => 'form-control select',
                    'id' => 'id_solicitante',
                ]) !!}
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
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="autorizacao-cotacao">Autorização de Cotação</label>
                {!! Form::textarea('autorizacao_cotacao', isset($requisicao) ? $requisicao->autorizacao_cotacao : old('autorizacao_cotacao'), ['class' => 'form-control', 'rows' => 2, 'id' => 'autorizacao-cotacao']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="local-entrega">Local de Entrega</label>
                {!! Form::textarea('local_entrega', isset($requisicao) ? $requisicao->local_entrega : old('local_entrega'), ['class' => 'form-control', 'rows' => 2, 'id' => 'local-entrega']) !!}
            </div>
        </div>
    </div>

</div>
