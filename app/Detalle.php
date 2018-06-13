<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{

    protected $table = 'detalles';


    public function users()
    {
        return $this->belongsTo('App\User');
    }

    public function agentesjuegos()
        {
            return $this->belongsTo('App\Agentesjuego');
        }


}
