<div class="card">
    <div class="card-body">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Descrição</th>
                    <th>Unidade</th>
                    <th>Qtde.Solicitada</th>
                    <th>Qtde.Cotada</th>
                    <th>Qtde.Atendida</th>
                    <th>Vr.Unitário</th>
                    <th>Vr.Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($item->itens as $i)
                    <tr class="row-itens-cotacao">
                        <td class="text-left text-small">
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
                            {{ 'R$ ' . number_format($i->valor_unitario, '2', ',', '.')  }}
                        </td>
                        <td class="text-right text-sm">
                            {{ 'R$ ' . number_format($i->valor_total, '2', ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
