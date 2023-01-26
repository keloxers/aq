<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests;
use App\Rendicion;
use App\Agente;
use App\Detalle;
use Carbon\Carbon;
use App\Cuenta;
use App\Movimiento;
use Validator;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Auth;

class RendicionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $rendicions = Rendicion::orderby('fecha','desc')->orderby('id','desc')->paginate(50);
        $title = "Rendicions";
        return view('rendicions.index', ['rendicions' => $rendicions, 'title' => $title ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Agregar nuevo rendicion";
        return view('rendicions.create', ['title' => $title]);
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
                    'agente' => 'required|exists:agentes,agente|max:75',
                    'periodo' => 'required|numeric|min:1|max:99999999',
                    'tj' => 'required|numeric|min:0|max:200',
                    

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


        $agente = Agente::where('agente', $request->agente)->first();

        $rendicion = new rendicion;
        $rendicion->users_id = Auth::user()->id;
        $rendicion->agentes_id = $agente->id;
        $rendicion->fecha = Carbon::parse($request->fecha)->format('Y/m/d');
        $rendicion->periodo = $request->periodo;
        $rendicion->tj = $request->tj;
        $rendicion->save();
        return redirect('/rendicions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $rendicion = rendicion::find($id);
      $title = "rendicions";
      return view('rendicions.show', ['rendicion' => $rendicion,'title' => $title]);

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
        $rendicion = rendicion::find($id);

        $title = "Editar rendicion";
        return view('rendicions.edit', [
            'rendicion' => $rendicion,
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
                    'agente' => 'required|exists:agentes,agente|max:75',
                    'periodo' => 'required|numeric|min:1|max:99999999',
                    'tj' => 'required|numeric|min:0|max:200',
                    

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

        

        $agente = Agente::where('agente', $request->agente)->first();

        $rendicion = Rendicion::find($id);

        if ($rendicion->estado<>'abierta') {
          $errors[] = 'No se puede modificar una rendicion que no este abierta!';
          return redirect()->back()->with('errors', $errors)->withInput();
        }

        $rendicion->users_id = Auth::user()->id;
        $rendicion->agentes_id = $agente->id;
        $rendicion->fecha = Carbon::parse($request->fecha)->format('Y/m/d');
        $rendicion->periodo = $request->periodo;
        $rendicion->tj = $request->tj;
        $rendicion->save();
        return redirect('/rendicions');
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
        $rendicions = Rendicion::find($id);
        $rendicions->delete();

        return redirect('/rendicions');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function finder(Request $request)
    {
        // falta poner fatepick en index rendiciones

        $rendicions = Rendicion::where('fecha', $request->fecha)->orderby('agentes_id')->paginate(15);
        $title = "rendicion: buscando " . $request->buscar;
        return view('rendicions.index', ['rendicions' => $rendicions, 'title' => $title ]);


    }


    public function search(Request $request){
         $term = $request->term;
         $datos = Rendicion::where('rendicion', 'like', '%'. $request->term . '%')->get();
         $adevol = array();
         if (count($datos) > 0) {
             foreach ($datos as $dato)
                 {
                     $adevol[] = array(
                         'id' => $dato->id,
                         'value' => $dato->rendicion,
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


     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function storepagos(Request $request)
     {

         $validator = Validator::make($request->all(), [
                     'importe_efectivo' => 'numeric',
                     'importe_premios' => 'numeric',

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



         $rendicion = Rendicion::find($request->rendicions_id);
         $rendicion->importe_efectivo = $request->importe_efectivo;
         $rendicion->importe_premios_quiniela = $request->importe_premios_quiniela;
         $rendicion->importe_premios_juegos = $request->importe_premios_juegos;         
         $rendicion->importe_saldo = $rendicion->importe_pagar - $rendicion->importe_efectivo - $rendicion->importe_premios_quiniela - $rendicion->importe_premios_juegos   ;
         $rendicion->save();
         return redirect('/detalles/' . $request->rendicions_id . '/detalles');

     }


     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function cerrar($id)
     {
         //
         $debe = 0;
         $haber = 0;
         $movimientodescripcion='';

         $rendicion = Rendicion::find($id);
         $saldo = $rendicion->importe_saldo;


         if ( $saldo > 0 ) {
           $debe = $saldo;
           $movimientodescripcion='Deuda por faltante en rendicion';
         } elseif ( $saldo < 0 ) {
           $haber = $saldo * -1;
           $movimientodescripcion='Sobrante a Favor agente en rendicion';
         }

         if ( $saldo <> 0 ) {
           $agente = Agente::find($rendicion->agentes_id);
           $cuentas_id =$agente->cuentas_id;
           $movimiento = new Movimiento;
           $movimiento->users_id = Auth::user()->id;
           $movimiento->cuentas_id = $cuentas_id;
           $movimiento->movimiento = $movimientodescripcion;
           $movimiento->debe = $debe;
           $movimiento->haber = $haber;
           $movimiento->enplanilla = 0;
           $movimiento->save();
         }
         $rendicion->users_id = Auth::user()->id;
         $rendicion->estado = 'cerrada';
         $rendicion->save();
         return redirect('/rendicions');
     }


     public function cerrada($id)
     {
         $rendicion = Rendicion::find($id);
         $rendicion->estado = 'cerrada';
         $rendicion->save();
         return redirect('/rendicions');
     }

     public function controlada($id)
     {
         $rendicion = Rendicion::find($id);
         $rendicion->estado = 'controlada';
         $rendicion->save();
         return redirect('/rendicions');
     }


     public function saldoaefectivo($id)
     {
         $rendicion = Rendicion::find($id);
         $importe_saldo = $rendicion->importe_saldo;
         $rendicion->importe_saldo = 0;
         $rendicion->importe_efectivo += $importe_saldo;
         $rendicion->save();
         return redirect('/detalles/' . $id . '/detalles');
     }

     




}
