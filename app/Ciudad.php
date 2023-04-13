<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'codigo_dane', 'departamento_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function departamento() {
        return $this->belongsTo('App\Departamento');
    }

    public function divisions() {
        return $this->hasMany('App\Division');
    }

    public function unions() {
        return $this->hasMany('App\Union');
    }

    public function asociacions() {
        return $this->hasMany('App\Asociacion');
    }
    
    public function zonas() {
        return $this->hasMany('App\Zona');
    }
    
    public function distritos() {
        return $this->hasMany('App\Distrito');
    }
    
    public function iglesias() {
        return $this->hasMany('App\Iglesia');
    }

}
