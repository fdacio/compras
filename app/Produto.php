<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    protected $fillable = ['nome', 'valor_unitario', 'id_unidade'];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'id_unidade');
    }
}
