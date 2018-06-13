<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests;
use App\Cuenta;

use Validator;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class CuentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $cuentas = Cuenta::orderby('id')->paginate(25);
        $title = "Cuentas";
        return view('cuentas.index', ['cuentas' => $cuentas, 'title' => $title ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Agregar nuevo cuenta";
        return view('cuentas.create', ['title' => $title]);
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
                    'cuenta' => 'required|unique:cuentas|max:75',

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

        $cuenta = new Cuenta;
        $cuenta->cuenta = $request->cuenta;
        $cuenta->save();
        return redirect('/cuentas');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $cuenta = Cuenta::find($id);
      $title = "Cuenta";
      return view('cuentas.show', ['cuenta' => $cuenta,'title' => $title]);

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
        $cuenta = Cuenta::find($id);
        // $ciudad = Ciudad::find($cuenta->ciudads_id);

        $title = "Editar cuenta";
        return view('cuentas.edit', [
            'cuenta' => $cuenta,
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
                  'cuenta' => 'required|unique:cuentas,id,'. $request->id . '|max:75',

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


        $cuenta = Cuenta::find($id);
        $cuenta->cuenta = $request->cuenta;
        $cuenta->save();
        return redirect('/cuentas');
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
        $cuentas = Cuenta::find($id);
        $cuentas->delete();

        return redirect('/cuentas');
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

        $cuentas = Cuenta::where('cuenta', 'like', '%'. $request->buscar . '%')->orderby('id')->paginate(15);
        $title = "cuenta: buscando " . $request->buscar;
        return view('cuentas.index', ['cuentas' => $cuentas, 'title' => $title ]);


    }


    public function search(Request $request){
         $term = $request->term;
         $datos = Cuenta::where('cuenta', 'like', '%'. $request->term . '%')->orderby('cuenta')->get();
         $adevol = array();
         if (count($datos) > 0) {
             foreach ($datos as $dato)
                 {
                     $adevol[] = array(
                         'id' => $dato->id,
                         'value' => $dato->cuenta,
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
