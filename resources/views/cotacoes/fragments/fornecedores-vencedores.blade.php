<div class="card">
    <div class="card-body">
        @foreach ($cotacao->fornecedoresVencedores as $item)
            <div class="alert alert-success">
                <strong>Fornecedor Vencedor:</strong>
                {{ $item->fornecedor->pessoa->nome_razao_social }}
            </div>
        @endforeach
    </div>
</div>
