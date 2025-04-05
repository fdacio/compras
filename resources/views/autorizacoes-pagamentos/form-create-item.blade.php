<div id="step2" class="setup-content">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <small class="text-danger">*Campos obrigatórios.</small>
            </div>
        </div>
    </div>

    {!! Form::open([
        'id' => 'form_autorizacoes_pagamentos_item',
        'method' => 'post',
        'route' => ['autorizacoes-pagamentos.item.store', $autorizacao->id],
    ]) !!}
    {!! Form::hidden('id', $autorizacao->id) !!}

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="descricao">Descrição do Item<small class="text-danger p-2">*</small></label>
                <textarea id="descricao" name="descricao" rows="4" class="form-control"></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group">
                <label for="opcional">Opcional</label>
                {!! Form::select('id_produto', [1 => 'Veículo', 2 => 'Produto'], old('opcional'), [
                    'placeholder' => 'Opcional',
                    'id' => 'opcional',
                    'class' => 'form-control select',
                ]) !!}
            </div>
        </div>
        <div class="col-xs-9 col-sm-9 col-md-9">
            <div class="form-group d-none" id="div-item-veiculo">
                <label for="veiculos">Veículo</label>
                {!! Form::select('id_veiculo', $veiculos, old('id_veiculo'), [
                    'placeholder' => 'Selecione o Veículo',
                    'id' => 'veiculos',
                    'class' => 'form-control select',
                ]) !!}
            </div>

            <div class="form-group d-none" id="div-item-produto">
                <label for="produtos">Produto</label>
                {!! Form::select('id_produto', $produtos, old('id_produto'), [
                    'placeholder' => 'Selecione o Produto',
                    'id' => 'produtos',
                    'class' => 'form-control select',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            {!! Form::button('Adicionar', [
                'type' => 'submit',
                'id' => 'btn-adicionar-documento',
                'class' => 'btn btn-primary',
            ]) !!}
        </div>
    </div>
    {!! Form::close() !!}


    <div class="mt-4 row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <th>Item</th>
                        <th>Descrição</th>
                        <th style="width: 45px;"></th>
                    </thead>
                    <tbody>
                        @if ($autorizacao->itens->count() == 0)
                            <tr>
                                <th class="text-center" colspan="3">Nenhum item cadastrado</th>
                            </tr>
                        @else
                            @foreach ($autorizacao->itens as $item)
                                <tr>
                                    <td>{{ $item->item }}</td>
                                    <td>
                                        {{ $item->descricao }}
                                        @if ($item->veiculo)
                                            <div>
                                                <strong>Veículo:</strong>
                                                {{ $item->veiculo->placa . '-' . $item->veiculo->marca . ' ' . $item->veiculo->modelo }}
                                            </div>
                                        @endif
                                        @if ($item->produto)
                                            <div>
                                                <strong>Produto:</strong>
                                                {{ $item->produto->nome . '-' . $item->produto->unidade->nome }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="text-nowrap">
                                        {!! Form::open([
                                            'id' => 'form_excluir_' . $item->id,
                                            'method' => 'delete',
                                            'route' => ['autorizacoes-pagamentos.del-item.destroy', $autorizacao->id],
                                            'style' => 'display: inline',
                                        ]) !!}
                                        {!! Form::hidden('id_autorizacao_pagamento_item', $item->id) !!}
                                        {!! Form::button('<i class="fa fa-trash"></i>', [
                                            'class' => 'btn btn-danger modal-excluir',
                                            'style' => 'padding: 1px 6px;',
                                        ]) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#opcional").change(function() {
                let valor = $(this).val();
                if (valor == 1) {
                    $("#div-item-veiculo").removeClass('d-none');
                    $("#div-item-produto").addClass('d-none');
                } else if (valor == 2) {
                    $("#div-item-veiculo").addClass('d-none');
                    $("#div-item-produto").removeClass('d-none');
                } else {
                    $("#div-item-veiculo").addClass('d-none');
                    $("#div-item-produto").addClass('d-none');
                }
            })
        });
    </script>
    {!! Html::script('js/modal-excluir.js') !!}
@endsection
