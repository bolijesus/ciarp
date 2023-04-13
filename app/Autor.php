<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'solicitud_id', 'docente_id', 'created_at', 'updated_at'
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

    public function docente() {
        return $this->belongsTo('App\Docente');
    }

}
