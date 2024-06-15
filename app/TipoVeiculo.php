<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoVeiculo extends Model
{
    protected $table = 'tipos_veiculos';
    protected $fillable = ['nome'];
}
