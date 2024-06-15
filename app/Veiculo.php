<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $table = 'veiculos';
    protected $fillable = ['id_frota', 'id_empresa', 'id_centro_custo', 'tipo', 'marca', 'modelo', 'placa', 'uf', 'cor', 'ano', 'renavan'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
    
    public function frota()
    {
        return $this->belongsTo(Frota::class, 'id_frota');
    }

    public function centroCusto()
    {
        return $this->belongsTo(CentroCusto::class, 'id_centro_custo');
    }


}
