<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class FormaPagamento extends Model
{
    protected $table = 'formas_pagamentos';
    protected $fillable = ['nome', 'sigla'];
    protected $auditInclude = ['nome', 'sigla'];
    
}
