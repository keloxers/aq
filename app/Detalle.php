<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{

    protected $table = 'detalles';


    // public function ciudads()
    // {
    //     return $this->belongsTo('App\Ciudad');
    // }

    public function agentesjuegos()
        {
            return $this->belongsTo('App\Agentesjuego');
        }


}
