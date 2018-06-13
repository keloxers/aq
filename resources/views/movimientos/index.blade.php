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
									<a href="/movimientos" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							<div class="widget-content">
								<div class="data-table-toolbar">
									<div class="row">
										<div class="col-md-4">
											{{ Form::open(array('route' => 'movimientos.finder')) }}
											<input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar...">
											{{ Form::close() }}
										</div>
										<div class="col-md-8">
											<div class="toolbar-btn-action">
												<a href="/movimientos/create" class="btn btn-success"><i class="fa fa-plus-circle"></i> Nuevo</a>
											</div>
										</div>
									</div>
								</div>

								<div class="table-responsive">
									<table data-sortable class="table table-hover table-striped">
										<thead>
											<tr>
												<th>Fecha</th>
												<th>Movimiento descripcion</th>
												<th>Cuenta</th>
												<th>Debe</th>
												<th>Haber</th>
											</tr>
										</thead>

										<tbody>
											@if ($movimientos)
											@foreach ($movimientos as $movimiento)
											<tr>
												<td>{{ Carbon::parse($movimiento->created_at)->format('d/m/Y') }}</td>
												<td>{{ $movimiento->movimiento }}</td>
												<td>{{ $movimiento->cuentas->cuenta }}</td>
												<td>{{ $movimiento->debe }}</td>
												<td>{{ $movimiento->haber }}</td>
											</tr>
											@endforeach
										</tbody>
										@endif
									</table>
								</div>

								<div class="data-table-toolbar">
									{{ $movimientos->links() }}
								</div>
							</div>
						</div>
					</div>

				</div>







@stop
