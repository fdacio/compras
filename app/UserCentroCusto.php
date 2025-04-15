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
    

}
