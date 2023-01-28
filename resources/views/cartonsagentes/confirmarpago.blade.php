@extends('layouts.app')

@section('content')

    @php
        use Carbon\Carbon;
        $fecha = Carbon::now();
    @endphp


    <div class="row">
        <div class="col-md-12">
            <div class="widget">
                <div class="widget-header transparent">
                    <h2><a href="/cartonsagentes"><i class="icon-left"></i></a> <strong>{{ $title }}</h2>
                    <div class="additional-btn">
                        <a href="/rendicions" class="hidden reload"><i class="icon-ccw-1"></i></a>
                        <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                        <a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
                    </div>
                </div>
                @if (session('errors') != null && count(session('errors')) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach (session('errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <div class="widget-content">

                    <div class="widget-content padding">
                        <div class="form-group">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Fecha entrega</label>
                                <div class="col-sm-3">
                                    {{ $fecha->format('m/d/Y') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-text" class="col-sm-2 control-label">Agente</label>
                                <div class="col-sm-5">
                                    {{ $cartonsagente->agentes->agente }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-text" class="col-sm-2 control-label">Juego</label>
                                <div class="col-sm-5">
                                    {{ $cartonsagente->juegos->juego }}
                                </div>
                            </div>							

                            <div class="form-group">
                                <label for="input-text" class="col-sm-2 control-label">Sorteo</label>
                                <div class="col-sm-5">
                                    {{ $cartonsagente->sorteo }}
                                </div>
                            </div>							

                            <div class="form-group">
                                <label for="input-text" class="col-sm-2 control-label">Cantidad</label>
                                <div class="col-sm-3">
                                    {{ $cartonsagente->cantidad }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-text" class="col-sm-2 control-label">Importe Entregado</label>
                                <div class="col-sm-3">
                                    $ {{ $cartonsagente->importe_entregado }}
                                </div>
                            </div>
							<br><br>
                            <div class="form-group">
                                <label for="input-text" class="col-sm-2 control-label">A Pagar</label>
                                <div class="col-sm-3">
                                   <h3><strong><div class="label label-success">$ {{ $cartonsagente->importe_apagar }}</div></strong></h3>
                                </div>
                            </div>


                        </div>
                        <div class="widget-content padding">
                            <div class="form-group">
                                <a href="/cartonsagentes/confirmarpago/{{$cartonsagente->id }}" class="btn btn-primary"><i class="fa fa-money"></i> Confirmar el pago</a>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>

    </div>


@stop
