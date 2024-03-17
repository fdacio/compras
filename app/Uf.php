<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
    protected $table = 'ufs';
    protected $fillable = ['nome', 'sigla'];

    public function cidades()
    {
        return $this->hasMany(Municipio::class, 'id_uf');
    }
}
