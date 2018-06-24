<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{

    protected $table = 'articulos';

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
