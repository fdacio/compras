<div id="step2" class="setup-content">
    <div class="card mb-2">
        <div class="card-body">
            {!! Form::open([
                'id' => 'form_requisicos_compras_item',
                'method' => 'post',
                'route' => ['requisicoes-compras.item.store', $requisicao->id],
            ]) !!}
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8">
                    @if ($requisicao->tipo == 'PRODUTO')
                        <div class="form-group">
                            <label for="produtos">Produto<small class="text-danger p-2">*</small></label>
                            {!! Form::select('id_produto', $produtos, old('id_produto'), [
                                'placeholder' => 'Selecione o Produto',
                                'id' => 'produtos',
                                'class' => 'form-control select',
                            ]) !!}
                        </div>
                    @else
                        <div class="form-group">
                            <label for="servico">Descrição do Serviço<small class="text-danger p-2">*</small></label>
                            <textarea id="servico" name="servico" rows="4" class="form-control"></textarea>
                        </div>
                    @endif
                </div>

                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label for="quantidade-solicitada">Quantidade Solicitada<small
                                class="text-danger p-2">*</small></label>
                        {!! Form::text('quantidade_solicitada', old('quantidade_solicitada'), [
                            'id' => 'quantidade-solicitada',
                            'maxlength' => '15',
                            'class' => 'form-control quantidade text-right',
                        ]) !!}
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 text-right">
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
                    <th>Produto/Serviço</th>
                    <th>Unidade</th>
                    <th class="text-right">Quantidade Solicitada</th>
                    <th style="width: 45px;"></th>
                </thead>
                <tbody>
                    @foreach ($requisicao->itens as $item)
                        <tr>
                            <td>{{ $item->item }}</td>
                            <td>
                                <p style="white-space: pre-wrap">{{ $item->descricao }}</p>
                            </td>
                            <td>{{ $item->unidade }}</td>
                            <td class="text-right">
                                <span class="quantidade-solicitada">{{ $item->quantidade_solicitada }}</span>
                            </td>
                            <td class="text-nowrap">
                                {!! Form::open([
                                    'id' => 'form_excluir_' . $item->id,
                                    'method' => 'delete',
                                    'route' => ['requisicoes-compras.del-item.destroy', $requisicao->id],
                                    'style' => 'display: inline',
                                ]) !!}
                                {!! Form::hidden('id_requisicao_compra_item', $item->id) !!}
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
        <div class="card-footer">
            <a href="{{ route('requisicoes-compras.gera.pdf', $requisicao->id) }}" class="btn btn-success"
                title="download" target="_blank">Demonstrativo</a>

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
