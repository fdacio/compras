<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotacao extends Model
{
    protected $table = 'cotacoes';

    protected $fillable = [
        'id_requisicao',
        'data',
        'id_usuario_cadastrou',
        'id_usuario_alterou'
    ];

    public function requisicao()
    {
        return $this->belongsTo('App\RequisicaoCompra', 'id_requisicao');
    }

    public function fornecedores()
    {
        return $this->hasMany('App\CotacaoFornecedor', 'id_cotacao');
    }

    public function usuarioCadastrou()
    {
        return $this->belongsTo('App\User', 'id_usuario_cadastrou');
    }

    public function usuarioAlterou()
    {
        return $this->belongsTo('App\User', 'id_usuario_alterou');
    }
}
