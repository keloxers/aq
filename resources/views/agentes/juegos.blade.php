@extends('layouts.app')

@section('content')

<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><strong>{{ $title}}</h2>
								<div class="additional-btn">
									<a href="/agentes" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							<div class="widget-content">
								<div class="data-table-toolbar">
									<div class="row">
										<div class="col-md-4">
											{{ Form::open(array('route' => 'agentes.finder')) }}
											<input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar...">
											{{ Form::close() }}
										</div>
										<div class="col-md-8">
											<div class="toolbar-btn-action">
												<a href="/agentes/{{$agente->id}}/createjuegos/" class="btn btn-success"><i class="fa fa-plus-circle"></i> Nuevo</a>
											</div>
										</div>
									</div>
								</div>

								<div class="table-responsive">
									<table data-sortable class="table table-hover table-striped">
										<thead>
											<tr>
												<th>Juego</th>
												<th>Porcentaje Agencia</th>
												<th>Porcentaje Agente</th>
												<th>Acción</th>
											</tr>
										</thead>

										<tbody>
											@if ($agentesjuegos)
											@foreach ($agentesjuegos as $agentesjuego)
											<tr>
												<td>{{ $agentesjuego->juegos->juego }}</td>
												<td>{{ $agentesjuego->porcentaje_agencia }}</td>
												<td>{{ $agentesjuego->porcentaje_agente }}</td>
												<td>
													<a href='/agentes/agentesjuegos/delete/{{ $agentesjuego->id }}'>
													<span class="label label-danger">Eliminar</span>
													</a>
												</td>
											</tr>
											@endforeach
										</tbody>
										@endif
									</table>
								</div>

								<div class="data-table-toolbar">

								</div>
							</div>
						</div>
					</div>

				</div>







@stop
