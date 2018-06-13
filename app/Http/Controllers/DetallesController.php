<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests;
use App\Rendicion;
use App\Agente;
use App\Agentesjuego;
use App\Detalle;
use Carbon\Carbon;

use Validator;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Auth;


class DetallesController extends Controller
{

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function detalles($id)
  {

    $rendicion = Rendicion::find($id);
    $detalles = Detalle::where('rendicions_id', $rendicion->id)->get();
    $title = "Detalles";
    // return view('detalles.detalles', ['rendicion' => $rendicion, 'detalles' => $detalles, 'title' => $title]);
    return view('detalles.index', ['rendicion' => $rendicion, 'detalles' => $detalles, 'title' => $title ]);
  }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $rendicions = Rendicion::orderby('fecha')->paginate(15);
        $title = "Rendicions";
        return view('rendicions.index', ['rendicions' => $rendicions, 'title' => $title ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $rendicions_id = $id;

        $rendicion = Rendicion::find($rendicions_id);
        $agentesjuegos = Agentesjuego::where('agentes_id', $rendicion->agentes_id)->get();

        $title = "Agregar detalles a la Rendicion";
        return view('detalles.create', ['rendicion' => $rendicion, 'agentesjuegos' => $agentesjuegos, 'title' => $title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $rendicions_id = $request->rendicions_id;
        Detalle::where('rendicions_id', $rendicions_id)->delete();

        $rendicion = Rendicion::find($rendicions_id);

        $agentesjuegos = Agentesjuego::where('agentes_id', $rendicion->agentes_id)->get();

        $importe_pagar = 0;

        if($agentesjuegos) {
  			     foreach ($agentesjuegos as $agentesjuego) {
                        $valor = $request->input($agentesjuego->juegos->juego);

                        if (is_numeric($valor)) {
                            $detalle = new Detalle;
                            $detalle->users_id = Auth::user()->id;
                            $detalle->recaudacion = $valor;
                            $detalle->comision_agente = $valor * $agentesjuego->porcentaje_agente /100;
                            $detalle->comision_agencia = $valor * $agentesjuego->porcentaje_agencia /100;
                            $detalle->importe_apagar = $valor - $detalle->comision_agente;
                            $detalle->rendicions_id = $rendicion->id;
                            $detalle->agentesjuegos_id = $agentesjuego->id;
                            $detalle->save();
                            $importe_pagar += $detalle->importe_apagar;
                        }
  									}
                    $rendicion = Rendicion::find($request->rendicions_id);
                    $rendicion->users_id = Auth::user()->id;
                    $rendicion->importe_pagar = $importe_pagar;
                    $rendicion->importe_premios = $request->premios;
                    $rendicion->importe_saldo = $rendicion->importe_pagar - $rendicion->importe_efectivo - $rendicion->importe_premios;
                    $rendicion->save();



  			}

        return redirect('/detalles/' . $rendicions_id . '/detalles');
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
        $ciudad = Ciudad::find($rendicion->ciudads_id);

        $title = "Editar rendicion";
        return view('rendicions.edit', [
            'rendicion' => $rendicion,
            'ciudad' => $ciudad,
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
                  'rendicion' => 'required|unique:rendicions,id,'. $request->id . '|max:75',
                  'ciudad' => 'required|exists:ciudads,ciudad'

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


        // $ciudad = Ciudad::where('ciudad', $request->ciudad)->first();


        //
        $rendicion = Rendicion::find($id);
        $rendicion->users_id = Auth::user()->id;
        $rendicion->rendicion = $request->rendicion;
        $rendicion->ciudads_id = $ciudad->id;
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
        //

        $rendicions = Rendicion::where('rendicion', 'like', '%'. $request->buscar . '%')->orderby('rendicion')->paginate(15);
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







}
