<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests;
use App\Barrio;
use App\Ciudad;

use Validator;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class BarriosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $barrios = Barrio::orderby('barrio')->paginate(15);
        $title = "Barrios";
        return view('barrios.index', ['barrios' => $barrios, 'title' => $title ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Agregar nuevo Barrio";
        return view('barrios.create', ['title' => $title]);
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
                    'barrio' => 'required|unique:barrios|max:75',

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

        $ciudad = Ciudad::where('ciudad', $request->ciudad)->first();

        $barrio = new Barrio;
        $barrio->barrio = $request->barrio;
        $barrio->ciudads_id = $ciudad->id;
        $barrio->save();
        return redirect('/barrios');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $barrio = Barrio::find($id);
      $title = "Barrios";
      return view('barrios.show', ['barrio' => $barrio,'title' => $title]);

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
        $barrio = Barrio::find($id);
        $ciudad = Ciudad::find($barrio->ciudads_id);

        $title = "Editar Barrio";
        return view('barrios.edit', [
            'barrio' => $barrio,
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
                  'barrio' => 'required|unique:barrios,id,'. $request->id . '|max:75',
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


        $ciudad = Ciudad::where('ciudad', $request->ciudad)->first();


        //
        $barrio = Barrio::find($id);
        $barrio->barrio = $request->barrio;
        $barrio->ciudads_id = $ciudad->id;
        $barrio->save();
        return redirect('/barrios');
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
        $barrios = Barrio::find($id);
        $barrios->delete();

        return redirect('/barrios');
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

        $barrios = Barrio::where('Barrio', 'like', '%'. $request->buscar . '%')->orderby('Barrio')->paginate(15);
        $title = "Barrio: buscando " . $request->buscar;
        return view('Barrios.index', ['Barrios' => $Barrios, 'title' => $title ]);


    }


    public function search(Request $request){
         $term = $request->term;
         $datos = Barrio::where('barrio', 'like', '%'. $request->term . '%')->get();
         $adevol = array();
         if (count($datos) > 0) {
             foreach ($datos as $dato)
                 {
                     $adevol[] = array(
                         'id' => $dato->id,
                         'value' => $dato->barrio,
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
