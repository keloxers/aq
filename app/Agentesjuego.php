<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agentesjuego extends Model
{

    protected $table = 'agentesjuegos';


    public function juegos()
    {
        return $this->belongsTo('App\Juego');
    }

    public function detalles()
    {
        return $this->hasMany('App\Detalle');
    }

    // public function clientes()
    //     {
    //         return $this->hasMany('App\Cliente');
    //     }


}
