<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cartonsagente extends Model
{

    protected $table = 'cartonsagentes';


    public function juegos()
    {
        return $this->belongsTo('App\Juego');
    }

    public function agentes()
    {
        return $this->belongsTo('App\Agente');
    }
    
    public function users()
    {
        return $this->belongsTo('App\User');
    }


}
