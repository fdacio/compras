<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisicaoCompraItem extends Model
{
    protected $table = 'requisicoes_compras_itens';
    protected $fillable = [
        'item', 
        'descricao', 
        'unidade', 
        'quantidade_solicitada',         
        'id_requisicao',
    ];
}
