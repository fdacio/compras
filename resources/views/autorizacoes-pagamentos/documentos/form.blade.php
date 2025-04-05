<div id="step3" class="setup-content">
    <div class="p-2 mb-2">
        {!! Form::open([
            'id' => 'form_autorizacao_documentos',
            'method' => 'post',
            'route' => 'autorizacoes-pagamentos.documentos.upload',
            'enctype' => 'multipart/form-data',
        ]) !!}
        <div class="card-body">
            {!! Form::hidden('id_autorizacao', $autorizacao->id) !!}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        {!! Form::text('nome', isset($autorizacao) ? $autorizacao->nome : old('nome'), [
                            'placeholder' => 'Informe o nome do documento.',
                            'class' => 'form-control',
                            'id' => 'nome',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="customFileDocumento">Arquivo</label>
                        <div class="custom-file">
                            <input name="file-documento" type="file" class="custom-file-input"
                                id="customFileDocumento" data-img="img-documento" accept="application/pdf">
                            <label class="custom-file-label" for="customFileDocumento"></label>
                        </div>
                        <p><small class="text-info">Tamanho máximo: 8Mbyte - Tipo: PDF</small></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    {!! Form::button('Salvar', [
                        'type' => 'submit',
                        'id' => 'btn-adicionar',
                        'class' => 'btn btn-primary',
                    ]) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="p-2">
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
                            <td>
                                {{ $item->descricao }}
                                @if ($item->veiculo)
                                <div>
                                    <strong>Veículo:</strong> {{ $item->veiculo->placa . '-' . $item->veiculo->marca . ' ' . $item->veiculo->modelo }}
                                </div>
                                @endif
                                @if ($item->produto)
                                <div>
                                    <strong>Produto:</strong> {{ $item->produto->nome . '-' . $item->produto->unidade->nome}}
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
                </tbody>
            </table>
        </div>
    </div>

</div>
@section('styles')
    <style>
        .custom-file-label::after {
            content: "Arquivo";
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('input[type="file"]').change(function(e) {
                var fileName = e.target.files[0].name;
                var inputFile = $(this);
                var className = inputFile.attr('data-img');
                var img = inputFile.parents('form').find('.' + className);
                inputFile.next('.custom-file-label').html(fileName);
                var reader = new FileReader();
                reader.onload = function(e) {
                    img.attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>
@endsection
