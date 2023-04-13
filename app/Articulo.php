<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'clasificacion', 'indexada', 'nombre_revista', 'fechapublicacion', 'evd_filiacion_upc', 'idioma', 'ps_solicitados', 'bo_solicitados', 'articulo_pdf', 'publindex', 'user_change', 'solicitud_id', 'created_at', 'updated_at'
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
