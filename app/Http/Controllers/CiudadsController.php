<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests;
use App\Ciudad;
use App\Provincia;

use Validator;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class CiudadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ciudads = Ciudad::orderby('ciudad')->paginate(15);
        $title = "Ciudades";
        return view('ciudads.index', ['ciudads' => $ciudads, 'title' => $title ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Agregar nueva Ciudad";
        return view('ciudads.create', ['title' => $title]);
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
                    'ciudad' => 'required|unique:ciudads|max:75',
                    'codigopostal' => 'required|unique:ciudads,codigopostal|max:10'

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


        $provincias = Provincia::where('provincia', $request->provincia)->first();


        $ciudads = new Ciudad;
        $ciudads->ciudad = $request->ciudad;
        $ciudads->codigopostal = $request->codigopostal;
        $ciudads->provincias_id = $provincias->id;
        $ciudads->save();
        return redirect('/ciudads');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $ciudad = Ciudad::find($id);
      $title = "Ciudades";
      return view('ciudads.show', ['ciudad' => $ciudad,'title' => $title]);
        //
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
        $ciudad = Ciudad::find($id);
        $provincia = Provincia::find($ciudad->provincias_id);

        $title = "Editar ciudad";
        return view('ciudads.edit', [
            'ciudad' => $ciudad,
            'provincia' => $provincia,
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
                  'ciudad' => 'required|unique:ciudads,id,'. $request->id . '|max:75',
                  'codigopostal' => 'required|unique:ciudads,codigopostal|max:10'

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


      $provincias = Provincia::where('provincia', $request->provincia)->first();


        //
        $ciudads = Ciudad::find($id);
        $ciudads->ciudad = $request->ciudad;
        $ciudads->codigopostal = $request->codigopostal;
        $ciudads->provincias_id = $provincias->id;
        $ciudads->save();
        return redirect('/ciudads');
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
        $ciudads = Ciudad::find($id);
        $ciudads->delete();

        return redirect('/ciudads');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function finder(Request $request)
    {
        $ciudads = Ciudad::where('ciudad', 'like', '%'. $request->buscar . '%')->orderby('ciudad')->paginate(15);
        $title = "Ciudad: buscando " . $request->buscar;
        return view('ciudads.index', ['ciudads' => $ciudads, 'title' => $title ]);
    }




        public function search(Request $request){
             $term = $request->term;
             $datos = Ciudad::where('ciudad', 'like', '%'. $request->term . '%')->get();
             $adevol = array();
             if (count($datos) > 0) {
                 foreach ($datos as $dato)
                     {
                         $adevol[] = array(
                             'id' => $dato->id,
                             'value' => $dato->ciudad,
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
