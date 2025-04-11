<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisicaoCompra extends Model
{
    
    protected $table = 'requisicoes_compras';
    protected $fillable = [
        'id_requisitante', 
        'id_solicitante', 
        'id_empresa',
        'id_veiculo', 
        'data', 
        'tipo', 
        'situacao',
        'id_usuario_autorizacao',
        'data_autorizacao',
        'observacao',
        'local_entrega',
        'urgente',
        'id_usuario_cadastrou',
        'id_usuario_alterou',

    ];
    const SITUACAO_PENDENTE = 'PENDENTE';
    const SITUACAO_AUTORIZADO = 'AUTORIZADO';
    const SITUACAO_CANCELADO = 'CANCELADO';   

    const SITUACOES = [
        [
            'label' => 'Pendente',
            'value' => self::SITUACAO_PENDENTE
        ],
        [
            'label' => 'Autorizado',
            'value' => self::SITUACAO_AUTORIZADO
        ],
        [
            'label' => 'Cancelado',
            'value' => self::SITUACAO_CANCELADO
        ],
    ];

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

    public function getSituacaoNomeAttribute()
    {
        $situacao = $this->situacao;
        $situacaoNome = '';
        foreach (self::SITUACOES as $item) {
            if ($item['value'] == $situacao) {
                $situacaoNome = $item['label'];
                break;
            }
        }
        return $situacaoNome;
    }

    public function requisitante()
    {
        return $this->belongsTo(CentroCusto::class, 'id_requisitante');
    }

    public function solicitante()
    {
        return $this->belongsTo(Solicitante::class, 'id_solicitante');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'id_veiculo');
    }

    public function usuarioAutorizacao()
    {
        return $this->belongsTo(User::class, 'id_usuario_autorizacao');
    }

    public function usuarioCadastrou()
    {
        return $this->belongsTo(User::class, 'id_usuario_cadastrou');
    }

    public function usuarioAlterou()
    {
        return $this->belongsTo(User::class, 'id_usuario_alterou');
    }

    public function itens()
    {
        return $this->hasMany(RequisicaoCompraItem::class, 'id_requisicao', 'id')
        ->orderBy('requisicoes_compras_itens.item', 'asc');
    }

}
