<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pqr extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'radicado', 'asunto', 'mensaje', 'user_id', 'solicitud_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function solicitud() {
        return $this->belongsTo('App\Solicitud');
    }

    public function respuestas() {
        return $this->hasMany('App\Respuesta');
    }

}
