<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombres', 'apellidos', 'identificacion', 'estado', 'email', 'password', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function grupousuarios() {
        return $this->belongsToMany('App\Grupousuario');
    }

    public function pqrs() {
        return $this->hasMany('App\Pqr');
    }

    public function respuestas() {
        return $this->hasMany('App\Respuesta');
    }

}
