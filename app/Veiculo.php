<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $table = 'veiculos';
    protected $fillable = ['id_frota', 'id_empresa', 'id_centro_custo', 'tipo', 'marca', 'modelo', 'placa', 'uf', 'cor', 'ano', 'renavan'];

}
