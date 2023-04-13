<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Software extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'titular', 'autores', 'result_pares', 'impacto_upc', 'codigo', 'instrucciones', 'ejecutable', 'cert_registro', 'cert_imp_upc', 'manual', 'user_change', 'solicitud_id', 'created_at', 'updated_at'
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
