<?php

namespace Cotacao;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FormaPagamento extends Model
{
    protected $table = 'formas_pagamentos';
    protected $fillable = ['nome', 'sigla'];
    protected $auditInclude = ['nome', 'sigla'];
    
}
