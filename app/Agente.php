<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agente extends Model
{

    protected $table = 'agentes';


    // public function ciudads()
    // {
    //     return $this->belongsTo('App\Ciudad');
    // }

    // public function agentesjuegos()
    //     {
    //         return $this->hasMany('App\Agentesjuego');
    //     }

    public function rendicions()
        {
            return $this->hasMany('App\Rendicion');
        }


}
