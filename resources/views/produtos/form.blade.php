<div class="form">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <small class="text-danger">*Campos obrigatórios.</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-10 col-sm-10 col-md-10">
            <div class="form-group">
                <label for="nome">Nome<small class="text-danger p-2">*</small></label>
                {!! Form::text('nome', isset($produto) ? $produto->nome : old('nome'), ['class' => 'form-control', 'id' => 'nome']) !!}
            </div>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2">
            <div class="form-group">
                <label for="valor-unitario">Valor Unitário</label>
                {!! Form::text('valor_unitario', isset($produto) ? 'R$ ' . number_format($produto->valor_unitario, '2', ',', '.') : old('valor_unitario'), ['class' => 'form-control real text-right', 'id' => 'valor-unitario']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="unidade">Unidade<small class="text-danger p-2">*</small></label>
                <div class="d-flex">
                    <div class="input-group">
                        {!! Form::select('id_unidade', $unidades, isset($produto->unidade) ? $produto->unidade->id : old('id_unidade'), ['placeholder' => 'Selecione', 'class' => 'form-control select', 'id' => 'unidade']) !!}
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-sm" type="button" data-toggle="modal"
                            data-target="#unidadesModal"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal Unidades-->
<div class="modal fade" id="unidadesModal" tabindex="-1" role="dialog" aria-labelledby="unidadesModalTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unidadesModalTitle">Cadastrar Unidade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="message">
            </div>
            <div class="modal-body">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="nome-unidade">Nome</label>
                        {!! Form::text('nome-unidade', '', ['class' => 'form-control input-nome', 'id' => 'nome-unidade']) !!}
                        <small class="error unidade nome text-danger"></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-save-unidade">Salvar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $(function() {

            $('.modal').on('show.bs.modal', function(event) {
                $('.input-nome').val('');
                $('.error').html('');
            });

            var saveItem = function(url, dados, select) {

                $.post(url, dados, function(response) {
                    if (response.success) {
                        swal(response.message, {
                            icon: 'success'
                        });
                        select.empty();
                        select.append('<option value="">Selecione</option>');
                        $.each(response.dados, function(id, nome) {
                            select.append('<option value=' + id + '>' +
                                nome + '</option>');
                        });
                        setTimeout(function() {
                            $('.modal').modal('hide');
                        }, 500);
                    }
                }).fail(function(response) {
                    var errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.error.' + key).html(value[0]);
                    });
                });

            };

            $('.btn-save-unidade').on('click', function() {
                var url = "{{ route('api.unidades.store') }}";
                var dados = {
                    "_token": $('input[name=_token]').val(),
                    "nome": $('input[name=nome-unidade]').val(),
                };
                var select = $('select[name=id_unidade]');
                saveItem(url, dados, select);
            });
    
        });
    </script>
@endsection
