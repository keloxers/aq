<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests;
use App\Articulo;
use Validator;
use App\Agente;
use App\Cuenta;
use App\Movimiento;
use Illuminate\Support\Facades\Auth;


use Illuminate\View\Middleware\ShareErrorsFromSession;

class ArticulosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $articulos = Articulo::orderby('articulo')->paginate(15);
        $title = "Articulos";
        return view('articulos.index', ['articulos' => $articulos, 'title' => $title ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Agregar nueva articulo";
        return view('articulos.create', ['title' => $title]);
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
                    'articulo' => 'required|unique:articulos|max:75',
                    'cuentas_id' => 'required|exists:cuentas,id',
                    'precio' => 'required|numeric',
                    'stock_actual' => 'required|numeric',
                    'stock_minimo' => 'required|numeric',

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

        $articulos = new Articulo;
        $articulos->cuentas_id = $request->cuentas_id;
        $articulos->articulo = $request->articulo;
        $articulos->precio = $request->precio;
        $articulos->stock_actual = $request->stock_actual;
        $articulos->stock_minimo = $request->stock_minimo;
        $articulos->save();
        return redirect('/articulos');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $articulo = Articulo::find($id);
      $title = "Articulos";
      return view('articulos.show', ['articulo' => $articulo,'title' => $title]);
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
        $articulo = Articulo::find($id);

        $title = "Editar Articulo";
        return view('articulos.edit', [
            'articulo' => $articulo,
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
                'articulo' => 'required|unique:articulos,id,' . $id . '|max:75',
                'cuentas_id' => 'required|exists:cuentas,id',
                'precio' => 'required|numeric',
                'stock_actual' => 'required|numeric',
                'stock_minimo' => 'required|numeric',
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


        //
        $articulos = Articulo::find($id);
        $articulos->cuentas_id = $request->cuentas_id;
        $articulos->articulo = $request->articulo;
        $articulos->precio = $request->precio;
        $articulos->stock_actual = $request->stock_actual;
        $articulos->stock_minimo = $request->stock_minimo;
        $articulos->save();
        return redirect('/articulos');
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
        $articulos = Articulo::find($id);
        $articulos->delete();

        return redirect('/articulos');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function finder(Request $request)
    {
        $articulos = Articulo::where('articulo', 'like', '%'. $request->buscar . '%')->orderby('articulo')->paginate(15);
        $title = "Articulo: buscando " . $request->buscar;
        return view('articulos.index', ['articulos' => $articulos, 'title' => $title ]);
    }




        public function search(Request $request){
             $term = $request->term;
             $datos = Articulo::where('articulo', 'like', '%'. $request->term . '%')->get();
             $adevol = array();
             if (count($datos) > 0) {
                 foreach ($datos as $dato)
                     {
                         $adevol[] = array(
                             'id' => $dato->id,
                             'value' => $dato->articulo,
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





         public function articulosmovimientos()
         {
             $title = "Agregar articulo movimiento";
             return view('articulos.articulosmovimiento', ['title' => $title]);
         }





         public function articulosmovimientosstore(Request $request)
         {

             $validator = Validator::make($request->all(), [
                         'agentes_id' => 'required|exists:agentes,id',
                         'cantidad' => 'required|numeric',
                         'articulos_id' => 'required|exists:articulos,id',

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

             $agente = Agente::find($request->agentes_id);
             $articulo = Articulo::find($request->articulos_id);
             $cuenta = Cuenta::find($articulo->cuentas_id);

             $debe = $request->cantidad * $articulo->precio;

             $movimiento = new Movimiento;
             $movimiento->users_id = Auth::user()->id;
             $movimiento->cuentas_id = $articulo->cuentas_id;
             $movimiento->movimiento = $request->cantidad . ' unidades de  ' . $articulo->articulo;
             $movimiento->debe = $debe;
             $movimiento->haber = 0;
             $movimiento->enplanilla = 0;
             $movimiento->save();

             $articulo->stock_actual -= $request->cantidad;
             $articulo->save();

             return redirect('/movimientos');

         }






}
