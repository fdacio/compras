<div class="card">
    <div class="card-body">
        @foreach ($cotacao->fornecedoresVencedores as $fornecedor)
            <div class="alert alert-success">
                <strong>
                    {{ $fornecedor->fornecedor->pessoa->nome_razao_social }}
                </strong>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th class="text-left text-sm">Item</th>
                                <th class="text-left text-sm">Descrição</th>
                                <th class="text-left text-sm">Unidade</th>
                                <th class="text-left text-sm">Qtde.Solicitada</th>
                                <th class="text-left text-sm">Qtde.Cotada</th>
                                <th class="text-left text-sm">Qtde.Atendida</th>
                                <th class="text-left text-sm">Vr.Unitário</th>
                                <th class="text-left text-sm">Vr.Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cotacao->fornecedores->where('id_fornecedor', $fornecedor->id_fornecedor) as $fornecedorItem)
                                @foreach ($fornecedorItem->itens as $i)
                                    <tr class="row-itens-cotacao">
                                        <td class="text-left text-sm">
                                            {{ $i->item }}
                                        </td>
                                        <td class="text-left text-sm">
                                            {{ $i->descricao }}
                                        </td>
                                        <td class="text-left text-sm">
                                            {{ $i->unidade }}
                                        </td>
                                        <td class="text-right text-sm">
                                            {{ $i->quantidade_solicitada }}
                                        </td>
                                        <td class="text-right text-sm">
                                            {{ $i->quantidade_cotada }}
                                        </td>
                                        <td class="text-right text-sm">
                                            {{ $i->quantidade_atendida }}
                                        </td>
                                        <td class="text-right text-sm">
                                            {{ 'R$ ' . number_format($i->valor_unitario, '2', ',', '.') }}
                                        </td>
                                        <td class="text-right text-sm">
                                            {{ 'R$ ' . number_format($i->valor_total, '2', ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tfoot>
                                    <tr>
                                        <td colspan="7" class="text-right text-sm">
                                            <strong>Total:</strong>
                                        </td>
                                        <td class="text-right text-sm">
                                            <strong>
                                                {{ 'R$ ' . number_format($i->sum('valor_total'), '2', ',', '.') }}
                                            </strong>
                                        </td>
                                    </tr>      
                                </tfoot>         
    
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>
