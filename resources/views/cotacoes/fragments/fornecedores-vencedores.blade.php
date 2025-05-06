<div class="card">
    <div class="card-body">
        @foreach ($cotacao->fornecedoresVencedores as $item)
            <div class="alert alert-success">
                <strong>
                {{ $item->fornecedor->pessoa->nome_razao_social }}
                </strong>
            </div>
        @endforeach
    </div>
</div>
