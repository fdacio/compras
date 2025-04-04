<?php

namespace App;

use App\FormaPagamento;
use Illuminate\Database\Eloquent\Model;

class AutorizacaoPagamento extends Model
{
    protected $table = 'autorizacoes_pagamentos';
    protected $fillable = [
        'id_favorecido',
        'id_centro_custo',
        'id_forma_pagamento',
        'data',
        'valor',
        'situacao',
        'observacao',
        'banco',
        'agencia',
        'conta',
        'operacao',
        'chave_pix',
        'id_usuario_autorizacao',
        'data_autorizacao',
        'paga',
        'data_pagamento',
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

    public function favorecido()
    {
        return $this->belongsTo(Favorecido::class, 'id_favorecido');
    }

    public function centroCusto()
    {
        return $this->belongsTo(CentroCusto::class, 'id_centro_custo');
    }

    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamento::class, 'id_forma_pagamento');
    }

    public function usuarioAutorizacao()
    {
        return $this->belongsTo(User::class, 'id_usuario_autorizacao');
    }

    public function itens() 
    {
        return $this->hasMany(AutorizacaoPagamentoItem::class, 'id_autorizacao', 'id')->orderBy('autorizacoes_pagamentos_itens.item', 'asc');
    }
}
