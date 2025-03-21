<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisicaoCompra extends Model
{
    
    protected $table = 'requisicoes_compras';
    protected $fillable = [
        'id_requisitante', 
        'id_solicitante', 
        'id_veiculo', 
        'data', 
        'tipo', 
        'autorizacao_cotacao', 
        'local_entrega'];
    
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

    
    public function getTipoNomeAttribute() 
    {
        $tipo = $this->tipo;
        $tipoNome = '';
        foreach (self::TIPOS as $tipoItem) {
            if ($tipoItem['value'] == $tipo) {
                $tipoNome = $tipoItem['label'];
                break;
            }
        }
        return $tipoNome;
    }

    public function requisitante()
    {
        return $this->belongsTo(CentroCusto::class, 'id_requisitante');
    }

    public function solicitante()
    {
        return $this->belongsTo(Solicitante::class, 'id_solicitante');
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'id_veiculo');
    }

    public function itens()
    {
        return $this->hasMany(RequisicaoCompraItem::class, 'id_requisicao', 'id')
        ->orderBy('item', 'asc');
    }

}
