<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'mensaje', 'pqr_id', 'user_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function pqr() {
        return $this->belongsTo('App\Pqr');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

}
