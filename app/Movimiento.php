<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{

    protected $table = 'movimientos';


    public function cuentas()
    {
        return $this->belongsTo('App\Cuenta');
    }
    //
    // public function agentesjuegos()
    //     {
    //         return $this->hasMany('App\Agentesjuego');
    //     }


}
