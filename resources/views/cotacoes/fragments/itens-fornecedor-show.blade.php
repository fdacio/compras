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
                    <tr>
                        <td>
                            {{ $i->item }}
                        </td>
                        <td>
                            <div>{{ $i->descricao }}</div>
                        </td>
                        <td>>
                            {{ $i->unidade }}
                        </td>
                        <td>
                            {{ $i->quantidade_solicitada }}
                        </td>
                        <td>
                            {{ $i->quantidade_cotada }}
                        </td>
                        <td>
                            {{ $i->quantidade_atendida }}
                        </td>
                        <td>
                            {{ $i->valor_unitario  }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
