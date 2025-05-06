<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CotacaoFornecedorVencedor extends Model
{
    protected $table = 'cotacoes_fornecedores_vencedores';

    protected $fillable = [
        'id_cotacao',
        'id_fornecedor'
    ];

    public function fornecedor()
    {
        return $this->belongsTo('App\Fornecedor', 'id_fornecedor');
    }


}
