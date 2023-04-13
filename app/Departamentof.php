<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamentof extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'facultad_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function facultad() {
        return $this->belongsTo('App\Facultad');
    }

}
