<div class="card">
    {!! Form::open([
        'method' => 'put',
        'route' => ['cotacoes.update', $cotacao->id],
    ]) !!}
    <div class="card-body">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="col-xs-1 col-sm-1 col-md-1">Item</th>
                    <th class="col-xs-7 col-sm-7 col-md-7">Descrição</th>
                    <th class="col-xs-2 col-sm-2 col-md-2">Unidade</th>
                    <th class="col-xs-2 col-sm-2 col-md-2">Qtde.Solicitada</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($item->itens as $i)
                    <tr>
                        <td class="col-xs-1 col-sm-1 col-md-1">
                            {{ $i->item }}
                        </td>
                        <td class="col-xs-7 col-sm-7 col-md-7">
                            <div>{{ $i->descricao }}</div>
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label for="quantidade_cotada[{{ $i->id }}]"
                                            class="text-sm mb-1">Qtde.Cotada</label>
                                        <input type="text" name="quantidade_cotada[{{ $i->id }}]"
                                            id="quantidade_cotada[{{ $i->id }}]"
                                            class="form-control form-control-sm text-right quantidade"
                                            value="{{ $i->quantidade_cotada }}" />
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label for="quantidade_atendida[{{ $i->id }}]"
                                            class="text-sm mb-1">Qtde.Atendida</label>
                                        <input type="text" name="quantidade_atendida[{{ $i->id }}]"
                                            id="quantidade_atendida[{{ $i->id }}]"
                                            class="form-control form-control-sm text-right quantidade"
                                            value="{{ $i->quantidade_atendida }}" />
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label for="valor_unitario[{{ $i->id }}]" class="text-sm mb-1">Valor
                                            Unitário</label>
                                        <input type="text" name="valor_unitario[{{ $i->id }}]"
                                            id="valor_unitario[{{ $i->id }}]"
                                            class="form-control form-control-sm text-right real"
                                            value="{{ $i->valor_unitario }}" />
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="col-xs-2 col-sm-2 col-md-2">
                            {{ $i->unidade }}
                        </td>
                        <td class="text-right col-xs-2 col-sm-2 col-md-2">
                            {{ $i->quantidade_solicitada }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
