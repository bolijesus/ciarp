<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'radicado', 'tipo', 'titulo', 'num_autores', 'evd_cred_upc', 'cvlac', 'gruplac', 'puntos_aproximados_ps', 'puntos_aproximados_bo', 'puntos_ps', 'puntos_bo', 'estado', 'observacion', 'grupo_investigacion', 'isbn', 'issn', 'acta', 'user_change', 'docente_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function docente() {
        return $this->belongsTo('App\Docente');
    }

    public function articulos() {
        return $this->hasMany('App\Articulo');
    }

    public function libros() {
        return $this->hasMany('App\Libro');
    }

    public function softwares() {
        return $this->hasMany('App\Software');
    }

    public function ponencias() {
        return $this->hasMany('App\Ponencia');
    }

    public function autors() {
        return $this->hasMany('App\Autor');
    }

}
