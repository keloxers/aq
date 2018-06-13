<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests;
use App\Cuenta;
use App\Movimiento;

use Validator;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class MovimientosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $movimientos = Movimiento::orderby('id')->paginate(25);
        $title = "movimientos";
        return view('movimientos.index', ['movimientos' => $movimientos, 'title' => $title ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Agregar nuevo movimiento";
        return view('movimientos.create', ['title' => $title]);
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
                    'cuentas_id' => 'required|exists:cuentas,id',
                    'debe' => 'required|numeric',
                    'haber' => 'required|numeric',

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

        $movimiento = new Movimiento;
        $movimiento->movimiento = $request->movimiento;
        $movimiento->cuentas_id = $request->cuentas_id;
        $movimiento->debe = $request->debe;
        $movimiento->haber = $request->haber;
        $movimiento->save();
        return redirect('/movimientos');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $movimiento = Movimiento::find($id);
      $title = "movimiento";
      return view('movimientos.show', ['movimiento' => $movimiento,'title' => $title]);

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
        $movimiento = Movimiento::find($id);
        // $ciudad = Ciudad::find($movimiento->ciudads_id);

        $title = "Editar movimiento";
        return view('movimientos.edit', [
            'movimiento' => $movimiento,
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
                  'movimiento' => 'required|unique:movimientos,id,'. $request->id . '|max:75',

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


        $movimiento = Movimiento::find($id);
        $movimiento->movimiento = $request->movimiento;
        $movimiento->save();
        return redirect('/movimientos');
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
        $movimientos = Movimiento::find($id);
        $movimientos->delete();

        return redirect('/movimientos');
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

        $movimientos = Movimiento::where('movimiento', 'like', '%'. $request->buscar . '%')->orderby('id')->paginate(15);
        $title = "movimiento: buscando " . $request->buscar;
        return view('movimientos.index', ['movimientos' => $movimientos, 'title' => $title ]);


    }


    public function search(Request $request){
         $term = $request->term;
         $datos = Movimiento::where('movimiento', 'like', '%'. $request->term . '%')->get();
         $adevol = array();
         if (count($datos) > 0) {
             foreach ($datos as $dato)
                 {
                     $adevol[] = array(
                         'id' => $dato->id,
                         'value' => $dato->movimiento,
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