<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorecido extends Model
{
    protected $table = 'favorecidos';
    
    protected $fillable = ['id_pessoa', 'banco', 'agencia', 'conta', 'operacao', 'chave_pix'];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa')->with(['pessoaFisica', 'pessoaJuridica']);
    }
}
