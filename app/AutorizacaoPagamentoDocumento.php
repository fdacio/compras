<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutorizacaoPagamentoDocumento extends Model
{
    protected $table = 'autorizacoes_pagamentos_documentos';
    protected $fillable = [
        'id_autorizacao',
        'nome',
        'arquivo',
    ];
}
