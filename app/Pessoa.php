<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $table = 'pessoas';

    protected $fillable = ['tipo_pessoa', 'logradouro', 'numero', 'complemento', 'bairro', 'cep', 'ponto_referencia', 'telefone', 'celular', 'email', 'id_municipio'];

    public const TIPO_PESSOA_FISICA = 'PF';

    public const TIPO_PESSOA_JURIDICA = 'PJ';
    
    public const TIPOS_PESSOAS = ['PF' => 'Pessoa Física', 'PJ' => 'Pessoa Jurídica'];

    protected $appends = ['cpf_cnpj', 'nome_razao_social', 'cidade'];

    public function pessoaJuridica()
    {
        return $this->hasOne(PessoaJuridica::class, 'id_pessoa');
    }

    public function pessoaFisica()
    {
        return $this->hasOne(PessoaFisica::class, 'id_pessoa');
    }

    public function isJuridica() 
    {
        return $this->attributes['tipo_pessoa'] == self::TIPO_PESSOA_JURIDICA;
    }

    public function isFisica() 
    {
        return $this->attributes['tipo_pessoa'] == self::TIPO_PESSOA_FISICA;
    }

    public function getEnderecoCompletoAttribute()
    {
        $enderecoCompleto = $this->attributes['logradouro'] . ', ' . $this->attributes['numero'];
        if (!empty($this->attributes['complemento'])) {
            $enderecoCompleto .= ' - ' . $this->attributes['complemento'];
        }
        if (!empty($this->attributes['bairro'])) {
            $enderecoCompleto .= ' - ' . $this->attributes['bairro'];
        }
        if (!empty($this->attributes['cep'])) {
            $enderecoCompleto .= ' - CEP: ' . $this->attributes['cep'];
        }        
        $enderecoCompleto .= '  ' . $this->cidade->nome . '-' . $this->cidade->estado->sigla;
        return $enderecoCompleto;
    }

    public function getEnderecoCompletoSemCidadeAttribute()
    {
        $enderecoCompleto = $this->attributes['logradouro'] . ', ' . $this->attributes['numero'];
        if (!empty($this->attributes['complemento'])) {
            $enderecoCompleto .= ' - ' . $this->attributes['complemento'];
        }
        if (!empty($this->attributes['bairro'])) {
            $enderecoCompleto .= ' - ' . $this->attributes['bairro'];
        }
        if (!empty($this->attributes['cep'])) {
            $enderecoCompleto .= ' - CEP: ' . $this->attributes['cep'];
        }        
        return $enderecoCompleto;
    }

    public function cidade()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio');
    }

    public function setCepAttribute($cep)
    {
        $this->attributes['cep'] = str_replace(['.', '-'], '', $cep);
    }

    public function setTelefoneAttribute($telefone)
    {
        $this->attributes['telefone'] = str_replace(['(', ')', '-', ' '], '', $telefone);
    }
   
    public function setCelularAttribute($celular)
    {
        $this->attributes['celular'] = str_replace(['(', ')', '-', ' '], '', $celular);
    }

    public function getCpfCnpjAttribute()
    {
       return (!empty($this->pessoaFisica()->first())) ? $this->pessoaFisica()->first()->cpf : $this->pessoaJuridica()->first()->cnpj;
    }

    public function getNomeRazaoSocialAttribute()
    {
       return (!empty($this->pessoaFisica()->first())) ? $this->pessoaFisica()->first()->nome : $this->pessoaJuridica()->first()->razao_social;
    }

    public function getCidadeAttribute()
    {
        return Municipio::find($this->attributes['id_municipio']);
    }

}
