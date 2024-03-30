<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    
    protected $fillable = ['id_pessoa'];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa')->with(['pessoaFisica', 'pessoaJuridica']);
    }
}
