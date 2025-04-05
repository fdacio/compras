<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutorizacaoPagamentoItem extends Model
{
    protected $table = 'autorizacoes_pagamentos_itens';
    protected $fillable = [
        'id_autorizacao',
        'id_veiculo',
        'id_produto',
        'item',
        'descricao',
        'unidade',
        'quantidade',
    ];

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'id_veiculo');
    }
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto');
    }
}
