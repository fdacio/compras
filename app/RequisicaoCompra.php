<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisicaoCompra extends Model
{
    
    protected $table = 'requisicoes_compras';
    protected $fillable = ['id_requisitante', 'id_solicitante', 'id_veiculo', 'data', 'tipo', 'autorizacao_cotacao', 'local_entrega'];
    
    const TIPOS = [
        [
            'label' => 'Produto',
            'value' => 'PRODUTO'
        ],
        [
            'label' => 'Serviço',
            'value' => 'SERVICO'
        ],
    ];

    
}
