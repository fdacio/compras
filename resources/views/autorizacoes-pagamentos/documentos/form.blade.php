<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="nome">Nome</label>
            {!! Form::text('nome', isset($autorizacao) ? $autorizacao->nome : old('nome'), ['placeholder' => 'Informe o nome do documento.', 'class' => 'form-control', 'id' => 'nome']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="customFileDocumento">Arquivo</label>
            <div class="custom-file">
                <input name="file-documento" type="file" class="custom-file-input" id="customFileDocumento"
                    data-img="img-documento" accept="application/pdf">
                <label class="custom-file-label" for="customFileDocumento"></label>
            </div>
            <p><small class="text-info">Tamanho máximo: 8Mbyte - Tipo: PDF</small></p>
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
