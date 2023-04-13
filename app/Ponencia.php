<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ponencia extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre_evento', 'fecha_evento', 'lugar', 'tipo', 'idioma', 'paginaweb', 'presenta_memorias', 'num_reconocidas', 'archivo_memorias', 'cert_ponente', 'user_change', 'solicitud_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function solicitud() {
        return $this->belongsTo('App\Solicitud');
    }

}
