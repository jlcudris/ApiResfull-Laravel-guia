<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes;

    const USUARIO_VERIFICADO='1';
    const USUARIO_NO_VERIFICADO='0';

    const USUARIO_ADMINISTRADOR='true';
    const USUARIO_REGULAR='false';

    protected $dates =['delete_at'];
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'password','verified','verification_token','admin','remember_token'
    ];

    public function setNameAttribute($valor){

        $this->attributes['name'] = strtolower($valor);

    }

    public function setEmailAttribute($valor){

        $this->attributes['email'] = strtolower($valor);

    }

    public function getNameAttribute($valor){

       return ucwords($valor);

    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','verification_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */


    public function esVerificado(){

        return $this->verified ==User::USUARIO_VERIFICADO;
    }

    public function esAdministrador(){

        return $this->admin ==User::USUARIO_ADMINISTRADOR;
    }

    public static function generarVerificacionToken(){

        return str_random(40);


    }

}
