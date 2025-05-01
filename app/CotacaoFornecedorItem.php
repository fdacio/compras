<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CotacaoFornecedorItem extends Model
{
    protected $table = 'cotacoes_fornecedores_itens';

    protected $fillable = [
        'id_cotacao_fornecedor',
        'item',
        'descricao',
        'unidade',
        'quantidade_solicitada',
        'quantidade_cotada',
        'quantidade_atendida',
        'valor_unitario',
        'valor_total',

    ];

    public function cotacaoFornecedor()
    {
        return $this->belongsTo('App\CotacaoFornecedor', 'id_cotacao_fornecedor');
    }
    
}