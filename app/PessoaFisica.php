<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PessoaFisica extends Model 
{

    protected $table = 'pessoas_fisicas';

    protected $fillable = ['id_pessoa', 'nome', 'cpf', 'rg', 'rg_emissao', 'rg_orgao', 'nascimento', 'sexo'];

    protected $auditInclude = ['id_pessoa', 'nome', 'cpf', 'rg', 'rg_emissao', 'rg_orgao', 'nascimento', 'sexo'];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa');
    }

    public function setCpfAttribute($cpf)
    {
        $this->attributes['cpf'] = str_replace(['.', '-'], '', $cpf);
    }

    
    public function setNascimentoAttribute($nascimento)
    {
        if (!empty($nascimento)) {
            $this->attributes['nascimento'] = Carbon::createFromFormat('d/m/Y', $nascimento)->toDateString();
            
        }
    }

    public function setRgEmissaoAttribute($rgEmissao)
    {
        if (!empty($rgEmissao)) {
            $this->attributes['rg_emissao'] = Carbon::createFromFormat('d/m/Y', $rgEmissao)->toDateString();
        }
    }
    
    

}
