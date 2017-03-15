<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests;
use App\Agente;
use App\Juego;
use App\Agentesjuego;

use Validator;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AgentesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $agentes = Agente::orderby('agente')->paginate(25);
        $title = "Agentes";
        return view('agentes.index', ['agentes' => $agentes, 'title' => $title ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Agregar nuevo agente";
        return view('agentes.create', ['title' => $title]);
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
                    'agente' => 'required|unique:agentes|max:75',

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

        $agente = new agente;
        $agente->agente = $request->agente;
        $agente->maquina = $request->maquina;
        $agente->activo = 'si';
        $agente->save();
        return redirect('/agentes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $agente = Agente::find($id);
      $title = "agentes";
      return view('agentes.show', ['agente' => $agente,'title' => $title]);

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
        $agente = Agente::find($id);
        // $ciudad = Ciudad::find($agente->ciudads_id);

        $title = "Editar agente";
        return view('agentes.edit', [
            'agente' => $agente,
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
                  'agente' => 'required|unique:agentes,id,'. $request->id . '|max:75',

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
        $agente = Agente::find($id);
        $agente->agente = $request->agente;
        $agente->maquina = $request->maquina;
        $agente->save();
        return redirect('/agentes');
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
        $agentes = Agente::find($id);
        $agentes->delete();

        return redirect('/agentes');
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

        $agentes = Agente::where('agente', 'like', '%'. $request->buscar . '%')->orderby('agente')->paginate(15);
        $title = "Agente: buscando " . $request->buscar;
        return view('agentes.index', ['agentes' => $agentes, 'title' => $title ]);


    }


    public function search(Request $request){
         $term = $request->term;
         $datos = Agente::where('agente', 'like', '%'. $request->term . '%')->get();
         $adevol = array();
         if (count($datos) > 0) {
             foreach ($datos as $dato)
                 {
                     $adevol[] = array(
                         'id' => $dato->id,
                         'value' => $dato->agente,
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
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function juegos($id)
     {
         //

         $agente = Agente::find($id);
         $agentesjuegos = Agentesjuego::where('agentes_id', $id)->get();
         $title = "Juegos por Agente";

         return view('agentes.juegos', ['agente' => $agente, 'agentesjuegos' => $agentesjuegos,'title' => $title ]);
     }



     public function createjuegos($id)
     {
         //

         $agente = Agente::find($id);
         // $agentesjuegos = Agentesjuego::where('agentes_id', $id)->get();
         $agentesjuegos = Agentesjuego::All();
         $title = "Agregar Juegos por Agente";
         return view('agentes.createjuegos', ['agente' => $agente, 'agentesjuegos' => $agentesjuegos, 'title' => $title ]);
     }



     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function storeagentesjuegos(Request $request)
     {

        //  $validator = Validator::make($request->all(), [
        //              'juego' => 'required|unique:agentes|max:75',
         //
        //  ]);


        //  if ($validator->fails()) {
        //    foreach($validator->messages()->getMessages() as $field_name => $messages) {
        //      foreach($messages AS $message) {
        //          $errors[] = $message;
        //      }
        //    }
        //    return redirect()->back()->with('errors', $errors)->withInput();
        //    die;
        //  }

         $juego = Juego::find($request->juegos_id);

         $agentesjuego = new Agentesjuego;
         $agentesjuego->agentes_id = $request->agentes_id;
         $agentesjuego->juegos_id = $juego->id;
         $agentesjuego->porcentaje_agencia = $request->porcentaje_agencia;
         $agentesjuego->porcentaje_agente = $request->porcentaje_agente;

         $agentesjuego->save();
         return redirect('/agentes/' . $agentesjuego->agentes_id . '/juegos');
     }

     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function createjuegosdestroy($id)
     {
         //
         $agentesjuego = Agentesjuego::find($id);
         $agentes_id = $agentesjuego->agentes_id;
         $agentesjuego->delete();

         return redirect('/agentes/' . $agentes_id . '/juegos');
     }



}
