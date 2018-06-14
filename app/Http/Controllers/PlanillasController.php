<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests;
use App\Planilla;
use App\Movimiento;
use App\Cuenta;
use Carbon\Carbon;

use Validator;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PlanillasController extends Controller
{

    public function indexshow()
    {


        $title = "Ver Planilla";
        return view('planillas.indexshow', ['title' => $title ]);
    }

    public function index()
    {

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


    public function view(Request $request)
    {

        $fecha = Carbon::parse($request->fecha)->format('Y/m/d');

        $movimientos = Movimiento::whereDate('created_at', '=', $fecha)->where('enplanilla','=',1)->orderby('id','asc')->get();
        $title = "Movimientos: " .  $request->fecha;
        return view('planillas.index', ['movimientos' => $movimientos, 'title' => $title ]);

    }

    public function estadoscuenta()
    {


        $title = "Ver Cuenta";
        return view('planillas.estadoscuenta', ['title' => $title ]);
    }

    public function estadoscuentashow(Request $request)
    {

      $validator = Validator::make($request->all(), [
                  'cuentas_id' => 'required|exists:cuentas,id',

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

        $cuenta = Cuenta::find($request->cuentas_id);
        $movimientos = Movimiento::where('cuentas_id', '=', $request->cuentas_id)->orderby('id','asc')->get();
        $title = "Movimientos: " .  $cuenta->cuenta;
        return view('planillas.index', ['movimientos' => $movimientos, 'title' => $title ]);

    }


    public function finder(Request $request)
    {
        // falta poner fatepick en index planillaes

        $planillas = Planilla::where('fecha', $request->fecha)->orderby('agentes_id')->paginate(15);
        $title = "planilla: buscando " . $request->buscar;
        return view('planillas.index', ['planillas' => $planillas, 'title' => $title ]);


    }






}
