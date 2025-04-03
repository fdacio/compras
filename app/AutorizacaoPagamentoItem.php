<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutorizacaoPagamentoItem extends Model
{
    protected $table = 'autorizacoes_pagamentos_itens';
    protected $fillable = [
        'id_autorizacao',
        'item',
        'descricao',
        'unidade',
        'quantidade',
    ];
}
