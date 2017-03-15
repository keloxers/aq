<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{

    protected $table = 'juegos';


    // public function ciudads()
    // {
    //     return $this->belongsTo('App\Ciudad');
    // }
    //
    public function agentesjuegos()
        {
            return $this->hasMany('App\Agentesjuego');
        }


}
