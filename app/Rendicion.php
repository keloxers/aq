<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rendicion extends Model
{

    protected $table = 'rendicions';


    // public function ciudads()
    // {
    //     return $this->belongsTo('App\Ciudad');
    // }

    // public function agentesjuegos()
    //     {
    //         return $this->hasMany('App\Agentesjuego');
    //     }

    public function agentes()
    {
        return $this->belongsTo('App\Agente');
    }

    public function users()
    {
        return $this->belongsTo('App\User');
    }

}
