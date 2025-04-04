<div id="step2" class="setup-content">
    <div class="card mb-2">
        <div class="card-body">
            {!! Form::open([
                'id' => 'form_autorizacoes_pagamentos_item',
                'method' => 'post',
                'route' => ['autorizacoes-pagamentos.item.store', $autorizacao->id],
            ]) !!}
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
                    <div class="form-group d-none" id="div-item-produto">
                        <label for="opcional">Opcional<small class="text-danger p-2">*</small></label>
                        {!! Form::select('id_produto', [1 => "Veículo", 2 => "Produto"], old('opcional'), [
                            'placeholder' => 'Opcional',
                            'id' => 'opcional',
                            'class' => 'form-control select',
                        ]) !!}
                    </div>
                </div>

                <div class="col-xs-9 col-sm-9 col-md-9">
                    <div class="form-group d-none" id="div-item-produto">
                        <label for="produtos">Produto<small class="text-danger p-2">*</small></label>
                        {!! Form::select('id_produto', $produtos, old('id_produto'), [
                            'placeholder' => 'Selecione o Produto',
                            'id' => 'produtos',
                            'class' => 'form-control select',
                        ]) !!}
                    </div>

                    <div class="form-group hide" id="div-item-veiculo">
                        <label for="veiculos">Veículo<small class="text-danger p-2">*</small></label>
                        {!! Form::select('id_veiculo', $veiculos, old('id_veiculo'), [
                            'placeholder' => 'Selecione o Veículo',
                            'id' => 'veiculos',
                            'class' => 'form-control select',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                    {!! Form::button('Adicionar<i class="fa fa-plus ml-2"></i>', [
                        'type' => 'submit',
                        'id' => 'btn-adicionar',
                        'class' => 'btn btn-primary form-control',
                    ]) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="card">
        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px;">

            <table class="table table-striped table-hover">
                <thead>
                    <th>Item</th>
                    <th>Descrição</th>
                    <th style="width: 45px;"></th>
                </thead>
                <tbody>
                    @foreach ($autorizacao->itens as $item)
                        <tr>
                            <td>{{ $item->item }}</td>
                            <td>{{ $item->descricao }}</td>
                            <td class="text-nowrap">
                                {!! Form::open([
                                    'id' => 'form_excluir_' . $item->id,
                                    'method' => 'delete',
                                    'route' => ['autorizacoes-pageamentos.del-item.destroy', $autorizacao->id],
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
                </tbody>
            </table>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#")

        });
    </script>

    {!! Html::script('js/modal-excluir.js') !!}
@endsection
