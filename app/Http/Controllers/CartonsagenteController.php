<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests;
use App\Cartonsagente;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use App\Agentesjuego;
use App\Cuenta;
use App\Juego;

use App\Agente;
use App\Movimiento;

use Validator;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class CartonsagenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $cartonsagentes = Cartonsagente::orderby('id', 'desc')->paginate(25);
        $title = "Cartones agentes";
        return view('cartonsagentes.index', ['cartonsagentes' => $cartonsagentes, 'title' => $title ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Entrega de cartones a un agente";
        return view('cartonsagentes.create', ['title' => $title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
                    'fecha' => 'required|date_format:m/d/Y',
                    'agentes_id' => 'required|exists:agentes,id',
                    'juegos_id' => 'required|exists:juegos,id',
                    'sorteo' => 'required|numeric',
                    'cantidad' => 'required|numeric|min:1|max:100',
                    'importe_entregado' => 'required|numeric|min:1|max:100000',

        ]);


        if ($validator->fails()) {
          foreach($validator->messages()->getMessages() as $field_name => $messages) {
            foreach($messages AS $message) {
                $errors[] = $message;
            }
          }
          return redirect()->back()->with('errors', $errors)->withInput();
          die;
        }

        $agentesjuego = Agentesjuego::where('agentes_id', $request->agentes_id)
                                    ->where('juegos_id', $request->juegos_id)
                                    ->where('activo', true)
                                    ->first();


        if ($agentesjuego == null) {
          $errors[] = "El agente no tiene asignado el juego";
          return redirect()->back()->with('errors', $errors)->withInput();
          die;
        }

        $juego = Juego::find($request->juegos_id);

        if ($juego == null) {
          $errors[] = "El juego no es válido";
          return redirect()->back()->with('errors', $errors)->withInput();
          die;
        }        


        $porcentaje_agencia = $agentesjuego->porcentaje_agencia;
        $porcentaje_agente = $agentesjuego->porcentaje_agente;

        $comision_agencia = $request->importe_entregado * $porcentaje_agencia / 100;
        $comision_agente = $request->importe_entregado * $porcentaje_agente / 100;



        $cartonsagente = new Cartonsagente;

        $cartonsagente->fecha = Carbon::parse($request->fecha)->format('Y/m/d');
        $cartonsagente->agentes_id = $request->agentes_id;
        $cartonsagente->juegos_id = $request->juegos_id;
        $cartonsagente->sorteo = $request->sorteo;
        $cartonsagente->cantidad = $request->cantidad;
        $cartonsagente->importe_entregado = $request->importe_entregado;
        $cartonsagente->comision_agencia = $comision_agencia;
        $cartonsagente->comision_agente = $comision_agente;
        $cartonsagente->importe_apagar = $cartonsagente->importe_entregado - $comision_agente;
        $cartonsagente->users_id = Auth::user()->id;
        $cartonsagente->save();




        $agente = Agente::find($request->agentes_id);

        if ($agente == null) {
          $errors[] = "El agente no existe";
          return redirect()->back()->with('errors', $errors)->withInput();
          die;
        }

        
        $cuenta = Cuenta::find($agente->cuentas_id);

        if ($cuenta == null) {
          $errors[] = "La cuenta no existe";
          return redirect()->back()->with('errors', $errors)->withInput();
          die;
        }


        $movimiento = new Movimiento;
        $movimiento->users_id = Auth::user()->id;
        $movimiento->cuentas_id = $cuenta->id;
        $movimiento->movimiento = "Entrega de cartones " . $juego->juego . " (" . $request->cantidad . " cartones)";
        $movimiento->debe = $cartonsagente->importe_apagar;
        $movimiento->haber = 0;
        $movimiento->enplanilla = false;
        $movimiento->save();        

        $cartonsagente->movimientos_id = $movimiento->id;
        $cartonsagente->save();

        return redirect('/cartonsagentes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $cartonsagente = cartonsagente::find($id);
      $title = "cartonsagentes";
      return view('cartonsagentes.show', ['cartonsagente' => $cartonsagente,'title' => $title]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $cartonsagente = cartonsagente::find($id);

        if ($cartonsagente->estado <> 'entregado') {
          $errors[] = "El estado no es entregado, ya esta pagado o anulado";
          return redirect()->back()->with('errors', $errors)->withInput();
          die;
        }


        $title = "Editar cartonsagente";
        return view('cartonsagentes.edit', [
            'cartonsagente' => $cartonsagente,
            'title' => $title
          ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {



      $validator = Validator::make($request->all(), [
        'fecha' => 'required|date_format:m/d/Y',
        'agentes_id' => 'required|exists:agentes,id',
        'juegos_id' => 'required|exists:juegos,id',
        'sorteo' => 'required|numeric',
        'cantidad' => 'required|numeric|min:1|max:100',
        'importe_entregado' => 'required|numeric|min:1|max:100000',

        ]);


        if ($validator->fails()) {
        foreach($validator->messages()->getMessages() as $field_name => $messages) {
        foreach($messages AS $message) {
            $errors[] = $message;
        }
        }
        return redirect()->back()->with('errors', $errors)->withInput();
        die;
        }

        $agentesjuego = Agentesjuego::where('agentes_id', $request->agentes_id)
                                ->where('juegos_id', $request->juegos_id)
                                ->where('activo', true)
                                ->first();


        if ($agentesjuego == null) {
            $errors[] = "El agente no tiene asignado el juego";
            return redirect()->back()->with('errors', $errors)->withInput();
        die;
        }


        $porcentaje_agencia = $agentesjuego->porcentaje_agencia;
        $porcentaje_agente = $agentesjuego->porcentaje_agente;

        $comision_agencia = $request->importe_entregado * $porcentaje_agencia / 100;
        $comision_agente = $request->importe_entregado * $porcentaje_agente / 100;

        $cartonsagente = Cartonsagente::find($id);

        if ($cartonsagente->estado <> 'entregado') {
          $errors[] = "El estado no es entregado, ya esta pagado o anulado";
          return redirect()->back()->with('errors', $errors)->withInput();
          die;
        }

        $cartonsagente->fecha = Carbon::parse($request->fecha)->format('Y/m/d');
        $cartonsagente->agentes_id = $request->agentes_id;
        $cartonsagente->juegos_id = $request->juegos_id;
        $cartonsagente->sorteo = $request->sorteo;
        $cartonsagente->cantidad = $request->cantidad;
        $cartonsagente->importe_entregado = $request->importe_entregado;
        $cartonsagente->comision_agencia = $comision_agencia;
        $cartonsagente->comision_agente = $comision_agente;
        $cartonsagente->importe_apagar = $cartonsagente->importe_entregado - $comision_agente;
        $cartonsagente->users_id = Auth::user()->id;
        $cartonsagente->save();



        $agente = Agente::find($cartonsagente->agentes_id);

        if ($agente == null) {
          $errors[] = "El agente no existe";
          return redirect()->back()->with('errors', $errors)->withInput();
          die;
        }


        $cuenta = Cuenta::find($agente->cuentas_id);

        if ($cuenta == null) {
          $errors[] = "La cuenta no existe";
          return redirect()->back()->with('errors', $errors)->withInput();
          die;
        }
         
        $juego = Juego::find($cartonsagente->juegos_id);

        if ($juego == null) {
          $errors[] = "El juego no es válido";
          return redirect()->back()->with('errors', $errors)->withInput();
          die;
        }        



        $movimiento = Movimiento::find($cartonsagente->movimientos_id);
        $movimiento->users_id = Auth::user()->id;
        $movimiento->cuentas_id = $cuenta->id;
        $movimiento->movimiento = "Entrega de cartones " . $juego->juego . " (" . $request->cantidad . " cartones)";
        $movimiento->debe = $cartonsagente->importe_apagar;
        $movimiento->haber = 0;
        $movimiento->enplanilla = false;
        $movimiento->save();        


        return redirect('/cartonsagentes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $cartonsagentes = cartonsagente::find($id);
        $cartonsagentes->delete();

        return redirect('/cartonsagentes');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function finder(Request $request)
    {
        //

        $cartonsagentes = cartonsagente::where('cartonsagente', 'like', '%'. $request->buscar . '%')->orderby('id')->paginate(15);
        $title = "cartonsagente: buscando " . $request->buscar;
        return view('cartonsagentes.index', ['cartonsagentes' => $cartonsagentes, 'title' => $title ]);


    }


    public function search(Request $request){
         $term = $request->term;
         $datos = cartonsagente::where('cartonsagente', 'like', '%'. $request->term . '%')->get();
         $adevol = array();
         if (count($datos) > 0) {
             foreach ($datos as $dato)
                 {
                     $adevol[] = array(
                         'id' => $dato->id,
                         'value' => $dato->cartonsagente,
                     );
             }
         } else {
                     $adevol[] = array(
                         'id' => 0,
                         'value' => 'no hay coincidencias para ' .  $term
                     );
         }
          return json_encode($adevol);
     }


     public function pago($id)
     {
         
 
         $cartonsagente = Cartonsagente::find($id);
         $title = "Confirmar pago:  " . $cartonsagente->agentes->agente;
         return view('cartonsagentes.confirmarpago', ['cartonsagente' => $cartonsagente, 'title' => $title ]);
 
 
     }
 


     public function confirmarpago($id)
     {
       
      $cartonsagente = Cartonsagente::find($id);

      if ($cartonsagente->estado <> 'entregado') {
        $errors[] = "El carton ya fue pagado o esta anulado";
        return redirect()->back()->with('errors', $errors)->withInput();
        die;
      } 

      $cartonsagente->estado = 'pagado';
      $cartonsagente->save();



      $agente = Agente::find($cartonsagente->agentes_id);

      if ($agente == null) {
        $errors[] = "El agente no existe";
        return redirect()->back()->with('errors', $errors)->withInput();
        die;
      }

      
      $cuenta = Cuenta::find($agente->cuentas_id);

      if ($cuenta == null) {
        $errors[] = "La cuenta no existe";
        return redirect()->back()->with('errors', $errors)->withInput();
        die;
      }

      $juego = Juego::find($cartonsagente->juegos_id);

      if ($juego == null) {
        $errors[] = "El juego no es válido";
        return redirect()->back()->with('errors', $errors)->withInput();
        die;
      }        



      $movimiento = new Movimiento;
      $movimiento->users_id = Auth::user()->id;
      $movimiento->cuentas_id = $cuenta->id;
      $movimiento->movimiento = "Pago de cartones " . $juego->juego . " (" . $cartonsagente->cantidad . " cartones)";
      $movimiento->debe = 0;
      $movimiento->haber = $cartonsagente->importe_apagar;
      $movimiento->enplanilla = true;
      $movimiento->save();        



      return redirect('/cartonsagentes');
      


 
     }



}
