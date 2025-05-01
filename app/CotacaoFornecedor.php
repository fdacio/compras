<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CotacaoFornecedor extends Model
{
    protected $table = 'cotacoes_fornecedores';

    protected $fillable = [
        'id_cotacao',
        'id_fornecedor',
        'id_usuario_cadastrou',
    ];
    
    public function cotacao()
    {
        return $this->belongsTo('App\Cotacao', 'id_cotacao');
    }

    public function fornecedor()
    {
        return $this->belongsTo('App\Fornecedor', 'id_fornecedor');
    }
    
    public function usuarioCadastrou()
    {
        return $this->belongsTo('App\User', 'id_usuario_cadastrou');
    }

    public function itens()
    {
        return $this->hasMany('App\CotacaoFornecedorItem', 'id_cotacao_fornecedor');
    }
}