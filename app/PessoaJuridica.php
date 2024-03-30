<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PessoaJuridica extends Model
{
    protected $table = 'pessoas_juridicas';

    protected $fillable = ['id_pessoa', 'cnpj', 'cgf', 'razao_social', 'nome_fantasia'];

    protected $auditInclude = ['id_pessoa', 'cnpj', 'cgf', 'razao_social', 'nome_fantasia'];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa');
    }

    public function setCnpjAttribute($cnpj)
    {
        $this->attributes['cnpj'] = str_replace(['.', '-', '/'], '', $cnpj);
    }
}
