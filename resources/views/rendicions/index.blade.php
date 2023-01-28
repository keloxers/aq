@extends('layouts.app')

@section('content')


    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <link href="/assets/libs/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />


    <?php
        use Carbon\Carbon;
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="widget">
                <div class="widget-header transparent">
                    <h2><strong>{{ $title }}</h2>
                    <div class="additional-btn">
                        <a href="/rendicions" class="hidden reload"><i class="icon-ccw-1"></i></a>
                        <a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
                        <a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="data-table-toolbar">
                        <div class="row">
                            <div class="col-md-4">
                                {{ Form::open(['route' => 'rendicions.filtrar']) }}
                                <input type="text" id="agente" name="agente" class="form-control" placeholder="Filtrar por ...">
								{{ Form::hidden('agentes_id', '', array('id' => 'agentes_id', 'name' => 'agentes_id')) }}
                                {{ Form::close() }}
                            </div>
                            <div class="col-md-8">
                                <div class="toolbar-btn-action">
                                    <a href="/rendicions/create" class="btn btn-success"><i class="fa fa-plus-circle"></i>
                                        Nuevo</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table data-sortable class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Fecha</th>
                                    <th>Agente</th>
                                    <th>Tj</th>
                                    <th>Periodo</th>
                                    <th>Saldo</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                    <th>Cargo</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($rendicions)
                                    @foreach ($rendicions as $rendicion)
                                        <tr>
                                            <td>
                                                @if ($rendicion->estado == 'abierta')
                                                    <a href='/rendicions/{{ $rendicion->id }}/edit'>
                                                        <span class="label label-primary">
                                                            <icon class="fa fa-pencil"></icon>
                                                        </span>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ Carbon::parse($rendicion->fecha)->format('d/m/Y') }}</td>
                                            <td>{{ $rendicion->agentes->agente }}</td>
                                            <td>{{ $rendicion->tj }}</td>
                                            <td>{{ $rendicion->periodo }}</td>
                                            <td>{{ $rendicion->importe_saldo }}</td>
                                            <td>
                                                @if ($rendicion->estado == 'abierta')
                                                    <span class="label label-warning">{{ $rendicion->estado }}</span>
                                                @elseif ($rendicion->estado == 'cerrada')
                                                    @if (Auth::user()->tipo >= 2)
                                                        <a href='/rendicions/{{ $rendicion->id }}/controlada'>
                                                    @endif
                                                    <span class="label label-danger">{{ $rendicion->estado }}</span>
                                                    @if (Auth::user()->tipo >= 2)
                                                        </a>
                                                    @endif
                                                @else
                                                    @if (Auth::user()->tipo >= 2)
                                                        <a href='/rendicions/{{ $rendicion->id }}/cerrada'>
                                                    @endif
                                                    <span class="label label-info">{{ $rendicion->estado }}</span>
                                                    @if (Auth::user()->tipo >= 2)
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                
                                                <a href='/detalles/{{ $rendicion->id }}/detalles'>
                                                    
                                                        @if ($rendicion->estado == 'abierta')
                                                        <span class="label label-info">
                                                            Editar
                                                        @else
                                                            <span class="label label-success">
                                                            Ver
                                                        @endif
                                                    </span>
                                                </a>
                                            </td>
                                            <td>{{ $rendicion->users->name }}</td>
                                        </tr>
                                    @endforeach
                            </tbody>
                            @endif
                        </table>
                    </div>

                    <div class="data-table-toolbar">
                        {{ $rendicions->links() }}
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
        });
    </script>


@stop
