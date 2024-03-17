<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'municipios';
    protected $fillable = ['nome', 'id_uf', 'codigo_ibge'];

    protected $appends = ['uf'];

    public function estado()
    {
        return $this->belongsTo(Uf::class, 'id_uf');
    }

    public function getUfAttribute()
    {
        return Uf::find($this->attributes['id_uf']);
    }
}
