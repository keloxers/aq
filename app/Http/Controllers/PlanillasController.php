<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests;
use App\Planilla;
use Carbon\Carbon;

use Validator;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PlanillasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $planillas = Planilla::orderby('id','desc')->paginate(50);
        $title = "Planillas";
        return view('planillas.index', ['planillas' => $planillas, 'title' => $title ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Agregar nuevo planilla";
        return view('planillas.create', ['title' => $title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $validator = Validator::make($request->all(), [
        //             'fecha' => 'required|exists:agentes,agente|max:75',
        //
        // ]);
        //
        //
        // if ($validator->fails()) {
        //   foreach($validator->messages()->getMessages() as $field_name => $messages) {
        //     foreach($messages AS $message) {
        //         $errors[] = $message;
        //     }
        //   }
        //   return redirect()->back()->with('errors', $errors)->withInput();
        //   die;
        // }
        //
        //
        // $agente = Agente::where('agente', $request->agente)->first();

        $planilla = new Planilla;
        $planilla->fecha = Carbon::parse($request->fecha)->format('Y/m/d');
        $planilla->debe = 0;
        $planilla->haber = 0;
        $planilla->saldo = 0;
        $planilla->estado = 'abierta';
        $planilla->save();
        return redirect('/planillas');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // //
        // $planillas = planilla::find($id);
        // $planillas->delete();
        //
        // return redirect('/planillas');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function finder(Request $request)
    {
        // falta poner fatepick en index planillaes

        $planillas = Planilla::where('fecha', $request->fecha)->orderby('agentes_id')->paginate(15);
        $title = "planilla: buscando " . $request->buscar;
        return view('planillas.index', ['planillas' => $planillas, 'title' => $title ]);


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
         $planilla = Planilla::find($id);
         $planilla->estado = 'cerrada';
         $planilla->save();
         return redirect('/planillas');
     }






}
