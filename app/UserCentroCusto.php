<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCentroCusto extends Model
{
    protected $table = 'users_centros_custos';
    protected $fillable = [
        'id_user',
        'id_centro_custo',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function centroCusto()
    {
        return $this->belongsTo(CentroCusto::class);
    }
}
