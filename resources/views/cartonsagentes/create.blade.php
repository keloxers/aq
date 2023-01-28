@extends('layouts.app')

@section('content')

    @php
        use Carbon\Carbon;
        $fecha = Carbon::now();
    @endphp


    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <link href="/assets/libs/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />


    <div class="row">
        <div class="col-md-12">
            <div class="widget">
                <div class="widget-header transparent">
                    <h2><a href="/rendicions"><i class="icon-left"></i></a> <strong>{{ $title }}</h2>
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
                        {{ Form::open(['route' => 'cartonsagentes.store', 'class' => 'form-horizontal', 'role' => 'form', 'autocomplete' => 'off']) }}
                        <div class="form-group">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Fecha entrega</label>
                                <div class="col-sm-3">
                                    <input type="text" id="fecha" name="fecha"
                                        value="{{ $fecha->format('m/d/Y') }}" class="form-control datepicker-input">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-text" class="col-sm-2 control-label">Agente</label>
                                <div class="col-sm-5">
                                    {{ Form::text('agente', '', ['id' => 'agente', 'name' => 'agente', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese un Agente']) }}
                                    {{ Form::hidden('agentes_id', '', ['id' => 'agentes_id', 'name' => 'agentes_id']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-text" class="col-sm-2 control-label">Juego</label>
                                <div class="col-sm-5">
                                    {{ Form::text('juego', '', ['id' => 'juego', 'name' => 'juego', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese juego']) }}
                                    {{ Form::hidden('juegos_id', '', ['id' => 'juegos_id', 'name' => 'juegos_id']) }}
                                </div>
                            </div>							

                            <div class="form-group">
                                <label for="input-text" class="col-sm-2 control-label">Sorteo</label>
                                <div class="col-sm-5">
                                    {{ Form::text('sorteo', '', ['id' => 'sorteo', 'name' => 'sorteo', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese Sorteo']) }}
                                    {{ Form::hidden('sorteos_id', '', ['id' => 'sorteos_id', 'name' => 'sorteos_id']) }}
                                </div>
                            </div>							

                            <div class="form-group">
                                <label for="input-text" class="col-sm-2 control-label">Cantidad</label>
                                <div class="col-sm-3">
                                    {{ Form::text('cantidad', '', ['id' => 'cantidad', 'name' => 'cantidad', 'class' => 'form-control input-lg', 'placeholder' => 'Cantidad cartones']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input-text" class="col-sm-2 control-label">Importe Entregado</label>
                                <div class="col-sm-3">
                                    {{ Form::text('importe_entregado', '', ['id' => 'importe_entregado', 'name' => 'importe_entregado', 'class' => 'form-control input-lg', 'placeholder' => 'Importe entregado']) }}
                                </div>
                            </div>


                        </div>
                        <div class="widget-content padding">
                            <div class="form-group">
                                {{ Form::submit('Agregar', ['class' => 'btn btn-primary']) }}
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>


                </div>
            </div>
        </div>

    </div>

    <script>
        var jq = jQuery.noConflict();
        jq(document).ready(function() {

            $("#agente").autocomplete({
                source: "/agentes/search",
                select: function(event, ui) {
                    $('#agentes_id').val(ui.item.id);

                }
            });

            $("#juego").autocomplete({
                source: "/juegos/searchcartones",
                select: function(event, ui) {
                    $('#juegos_id').val(ui.item.id);

                }
            });



        });
    </script>
    <script src="assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
@stop
