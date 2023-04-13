<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'tipo', 'fecha_publicacion', 'editorial', 'idioma', 'num_editorial', 'libro_pdf', 'cert_vicerrectoria', 'user_change', 'solicitud_id', 'created_at', 'updated_at'
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
