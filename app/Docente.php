<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'tipodoc', 'numero_documento', 'primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido', 'sexo', 'correo', 'telefono', 'celular', 'dedicacion', 'puntos_iniciales', 'user_change', 'departamentof_id', 'categoria_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function categoria() {
        return $this->belongsTo('App\Categoria');
    }

    public function departamentof() {
        return $this->belongsTo('App\Departamentof');
    }

    public function solicituds() {
        return $this->hasMany('App\Solicitud');
    }

    public function autors() {
        return $this->hasMany('App\Autor');
    }

}
