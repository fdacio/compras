<div id="step3" class="setup-content">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <small class="text-danger">*Campos obrigatórios.</small>
            </div>
        </div>
    </div>

    {!! Form::open([
        'id' => 'form_autorizacao_documentos',
        'method' => 'post',
        'route' => 'autorizacoes-pagamentos.documentos.upload',
        'enctype' => 'multipart/form-data',
    ]) !!}
    {!! Form::hidden('id_autorizacao', $autorizacao->id) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="nome">Nome<small class="text-danger p-2">*</small></label>
                {!! Form::text('nome', isset($autorizacao) ? $autorizacao->nome : old('nome'), [
                    'class' => 'form-control',
                    'id' => 'nome',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="customFileDocumento">Arquivo<small class="text-danger p-2">*</small></label>
                <div class="custom-file">
                    <input name="file-documento" type="file" class="custom-file-input" id="customFileDocumento"
                        data-img="img-documento" accept="application/pdf">
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
                'id' => 'btn-salvar-documento',
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
                        <th>Nome</th>
                        <th style="width: 45px;"></th>
                    </thead>
                    <tbody>
                        @if ($autorizacao->documentos->count() == 0)
                            <tr>
                                <th class="text-center" colspan="2">Nenhum documento cadastrado</th>
                            </tr>
                        @else
                            @foreach ($autorizacao->documentos as $item)
                                <tr>
                                    <td>{{ $item->nome }}</td>

                                    <td class="text-nowrap">
                                        {!! Form::open([
                                            'id' => 'form_excluir_' . $item->id,
                                            'method' => 'delete',
                                            'route' => ['autorizacoes-pagamentos.documentos.destroy', $item->id],
                                            'style' => 'display: inline',
                                        ]) !!}
                                        {!! Form::hidden('id_autorizacao_pagamento_documento', $item->id) !!}
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
    {!! Html::script('js/modal-excluir.js') !!}
@endsection
