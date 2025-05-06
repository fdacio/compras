<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    protected $table = 'tipos_usuarios';

    protected $fillable = ['nome'];

    const NIVEL_MANUTENCAO = 1;
    const NIVEL_ADMINISTRADOR = 2;
    const NIVEL_GERENTE = 3;
    const NIVEL_OPERADOR = 4;   

}
