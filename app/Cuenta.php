<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{

    protected $table = 'cuentas';


    public function articulos()
    {
        return $this->belongsTo('App\Articulo');
    }
    //
    // public function agentesjuegos()
    //     {
    //         return $this->hasMany('App\Agentesjuego');
    //     }


}
