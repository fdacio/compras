<?php

namespace App;

use Cotacao\FormaPagamento;
use Illuminate\Database\Eloquent\Model;

class AutorizacaoPagamento extends Model
{
    protected $table = 'autorizacoes_pagamentos';
    protected $fillable = [
        'id_favorecido',
        'id_municipio',
        'id_veiculo',
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
    /*
    UPLOADS
    LOGIN_AUTORIZOU
    PAGOU_SIM_NAO
    DATA_HORA_AUTORIZOU
    DATA_HORA_PAGOU
*/
    const SITUACOES = [
        [
            'label' => 'Pendente',
            'value' => 'PENDENTE'
        ],
        [
            'label' => 'Autorizado',
            'value' => 'AUTORIZADO'
        ],
        [
            'label' => 'Cancelado',
            'value' => 'CANCELADO'
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

    public function municipio()
    {
        return $this->belongsTo(CentroCusto::class, 'id_municipio');
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'id_veiculo');
    }

    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamento::class, 'id_forma_pagamento');
    }

    public function usuarioAutorizacao()
    {
        return $this->belongsTo(User::class, 'id_usuario_autorizacao');
    }
}
