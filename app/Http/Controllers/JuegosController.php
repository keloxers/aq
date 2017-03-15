<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests;
use App\Juego;

use Validator;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class JuegosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $juegos = Juego::orderby('id')->paginate(25);
        $title = "juegos";
        return view('juegos.index', ['juegos' => $juegos, 'title' => $title ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Agregar nuevo juego";
        return view('juegos.create', ['title' => $title]);
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
                    'juego' => 'required|unique:juegos|max:75',

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

        $juego = new Juego;
        $juego->juego = $request->juego;
        $juego->save();
        return redirect('/juegos');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $juego = Juego::find($id);
      $title = "juegos";
      return view('juegos.show', ['juego' => $juego,'title' => $title]);

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
        $juego = Juego::find($id);
        // $ciudad = Ciudad::find($juego->ciudads_id);

        $title = "Editar juego";
        return view('juegos.edit', [
            'juego' => $juego,
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
                  'juego' => 'required|unique:juegos,id,'. $request->id . '|max:75',

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


        $juego = Juego::find($id);
        $juego->juego = $request->juego;
        $juego->save();
        return redirect('/juegos');
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
        $juegos = Juego::find($id);
        $juegos->delete();

        return redirect('/juegos');
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

        $juegos = Juego::where('juego', 'like', '%'. $request->buscar . '%')->orderby('id')->paginate(15);
        $title = "juego: buscando " . $request->buscar;
        return view('juegos.index', ['juegos' => $juegos, 'title' => $title ]);


    }


    public function search(Request $request){
         $term = $request->term;
         $datos = Juego::where('juego', 'like', '%'. $request->term . '%')->get();
         $adevol = array();
         if (count($datos) > 0) {
             foreach ($datos as $dato)
                 {
                     $adevol[] = array(
                         'id' => $dato->id,
                         'value' => $dato->juego,
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
