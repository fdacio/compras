<?php

namespace App;

use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'id_tipo', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Personalizar email de redefinição de senha
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public static function encryptSenha($senha)
    {
        return password_hash($senha, PASSWORD_BCRYPT);
    }

    public function tipo()
    {
        return $this->belongsTo('App\TipoUsuario', 'id_tipo');
    }

    public function centrosCustos() 
    {
        return $this->belongsToMany(UserCentroCusto::class, 'user_centro_custo', 'user_id', 'centro_custo_id')
            ->withPivot('id')
            ->withTimestamps();
    }

}
