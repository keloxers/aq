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
									<a href="/cartonsagentes" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							<div class="widget-content">
								<div class="data-table-toolbar">
									<div class="row">
										<div class="col-md-4">
											{{-- {{ Form::open(array('route' => 'cartonsagentes.finder')) }}
											<input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar...">
											{{ Form::close() }} --}}
										</div>
										<div class="col-md-8">
											<div class="toolbar-btn-action">
												<a href="/cartonsagentes/create" class="btn btn-success"><i class="fa fa-plus-circle"></i> Nuevo</a>
											</div>
										</div>
									</div>
								</div>

								<div class="table-responsive">
									<table data-sortable class="table table-hover table-striped">
										<thead>
											<tr>
												<th>Id</th>
												<th></th>
												<th>Fecha</th>
												<th>Agente</th>
												<th>Juego</th>
												<th><div align='right'>Cant.</div></th>
												<th><div align='right'>$ Entregado</div></th>
												<th><div align='right'>A Pagar</div></th>
												<th>Estado</th>
												<th>Usuario</th>
											</tr>
										</thead>

										<tbody>
											@if ($cartonsagentes)
											@foreach ($cartonsagentes as $cartonsagente)
											<tr>
												<td>{{ $cartonsagente->id }}</td>
												<td>
													@if ($cartonsagente->estado == 'entregado')
														<a href='/cartonsagentes/{{ $cartonsagente->id }}/edit'>
															<span class="label label-info">Editar</span>
														</a>
													@endif
												</td>
												<td>{{ Carbon::parse($cartonsagente->fecha)->format('d/m/Y') }}</td>
												<td>{{ $cartonsagente->agentes->agente }}</td>
												<td>{{ $cartonsagente->juegos->juego }}</td>
												<td><div align='right'>{{ $cartonsagente->cantidad }}</div></td>
												<td><div align='right'>{{ $cartonsagente->importe_entregado }}</div></td>
												<td><div align='right'>{{ $cartonsagente->importe_apagar }}</div></td>
												<td>
													
														@if ($cartonsagente->estado == 'entregado')
															<a href='/cartonsagentes/{{ $cartonsagente->id }}/pago'>
																<span class="label label-danger">{{ $cartonsagente->estado }} Pagar y registrar</span>
															</a>
														@elseif ($cartonsagente->estado == 'pagado')
															<span class="label label-success">{{ $cartonsagente->estado }}</span>
														@else
															<span class="label label-default">{{ $cartonsagente->estado }}</span>
														@endif
													
												</td>
												<td>
													{{ $cartonsagente->users->name }}
												</td>
											</tr>
											@endforeach
										</tbody>
										@endif
									</table>
								</div>

								<div class="data-table-toolbar">
									{{ $cartonsagentes->links() }}
								</div>
							</div>
						</div>
					</div>

				</div>







@stop
