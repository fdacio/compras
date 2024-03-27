<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CentroCusto extends Model
{
    protected $table = 'centros_custos';
    protected $fillable = ['nome'];
}
