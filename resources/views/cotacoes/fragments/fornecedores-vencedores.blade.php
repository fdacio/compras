<div class="card">
    <div class="card-body">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="text-left text-sm">Fonecedor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cotacao->fornecedoresVencedores as $item)
                    <tr class="row-itens-cotacao">
                        <td class="text-left text-sm">
                            {{ $item->fornecedor->pessoa->nome_razao_social }}
                        </td>
                    </tr>    
                @endforeach
            </tbody>
        </table>
    </div>
</div>
