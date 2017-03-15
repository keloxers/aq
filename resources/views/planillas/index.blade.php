@extends('layouts.app')

@section('content')
<?php
use Carbon\Carbon;
?>
<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><strong>{{ $title}}</h2>
								<div class="additional-btn">
									<a href="/planillas" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							<div class="widget-content">
								<div class="data-table-toolbar">
									<div class="row">
										<div class="col-md-4">
											{{ Form::open(array('route' => 'planillas.finder')) }}
											<input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar...">
											{{ Form::close() }}
										</div>
										<div class="col-md-8">
											<div class="toolbar-btn-action">
												<a href="/planillas/create" class="btn btn-success"><i class="fa fa-plus-circle"></i> Nuevo</a>
											</div>
										</div>
									</div>
								</div>

								<div class="table-responsive">
									<table data-sortable class="table table-hover table-striped">
										<thead>
											<tr>
												<th>Fecha</th>
												<th>Debe</th>
												<th>Haber</th>
												<th>Saldo</th>
												<th>Estado</th>
												<th>Acción</th>
											</tr>
										</thead>

										<tbody>
											@if ($planillas)
											@foreach ($planillas as $planilla)
											<tr>
												<td>{{ Carbon::parse($planilla->fecha)->format('d/m/Y') }}</td>
												<td>{{ $planilla->debe }}</td>
												<td>{{ $planilla->haber }}</td>
												<td>{{ $planilla->saldo }}</td>
												<td>{{ $planilla->estado }}</td>
												<td>
													@if($planilla->estado=='abierta')
													<span class="label label-success">{{ $planilla->estado }}</span>
													@else
													<span class="label label-danger">{{ $planilla->estado }}</span>
													@endif
												</td>
												<td>

													<a href='/detalles/{{ $planilla->id }}/detalles'>
														@if($planilla->estado=='abierta')
														<span class="label label-primary">Editar</span>
														@else
														<span class="label label-primary">Ver</span>
														@endif
													</a>
												</td>
											</tr>
											@endforeach
										</tbody>
										@endif
									</table>
								</div>

								<div class="data-table-toolbar">
									{{ $planillas->links() }}
								</div>
							</div>
						</div>
					</div>

				</div>







@stop
