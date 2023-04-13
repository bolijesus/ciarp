<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function departamentofs() {
        return $this->hasMany('App\Departamentof');
    }

}
