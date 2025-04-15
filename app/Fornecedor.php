<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';
    
    protected $fillable = ['id_pessoa', 'banco', 'agencia', 'conta', 'operacao', 'chave_pix'];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa')->with(['pessoaFisica', 'pessoaJuridica']);
    }

}
