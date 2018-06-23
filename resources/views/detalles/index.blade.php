@extends('layouts.app')

@section('content')
<?php use Carbon\Carbon; ?>
<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><strong>{{ $title}}</h2>
								<div class="additional-btn">
									<a href="/detalles" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							<div class="widget-content">

								<div class="data-table-toolbar">
									<div class="row">
										<div class="col-md-12">
											<h3>{{ Carbon::parse($rendicion->fecha)->format('d/m/Y') }} : {{ $rendicion->agentes->agente}}</h3>
										</div>
									</div>
								</div>

								@if ($rendicion->estado=='abierta')
								<div class="data-table-toolbar">
									<div class="row">
										<div class="col-md-4">
										</div>
										<div class="col-md-8">
											@if ($rendicion->importe_pagar > 0)
												<div class="toolbar-btn-action">
													<a href="/rendicions/{{ $rendicion->id }}/cerrar" class="btn btn-danger"> Cerrar</a>
													<a href="/detalles/{{ $rendicion->id }}/create" class="btn btn-success"><i class="fa fa-plus-circle"></i> Re Cargar</a>

												</div>
											@else
												<div class="toolbar-btn-action">
													<a href="/detalles/{{ $rendicion->id }}/create" class="btn btn-success"><i class="fa fa-plus-circle"></i> Nuevo</a>
											</div>
											@endif
										</div>
									</div>
								</div>
								@endif

								<div class="table-responsive">
									<table data-sortable class="table table-hover table-striped">
										<thead>
											<tr>
												<th>Juego</th>
												<th>Recaudacion</th>
												<th>a Pagar</th>
												<th>Cargo</th>
											</tr>
										</thead>

										<tbody>
											<?php
												$apagar=0;
												$totalTj=0;
												$totalAgente=0;

											?>
											@if ($detalles)
											@foreach ($detalles as $detalle)
											<tr>
												<td>{{ $detalle->agentesjuegos->juegos->juego }}</td>
												<td>{{ $detalle->recaudacion }}</td>
												<td>{{ $detalle->importe_apagar }}</td>
												<td>{{ $detalle->users->name }}</td>
											</tr>
											<?php
													$apagar +=$detalle->importe_apagar;
													if ($detalle->agentesjuegos->juegos->tj) {
														$totalTj +=$detalle->recaudacion;
														$totalAgente += $detalle->comision_agente;
													}
											?>
											@endforeach

										</tbody>
										@endif
									</table>
								</div>

								<div class="data-table-toolbar">
									<div class="row">
										<div class="col-md-6">
											<h3><b>Total TJ:$ </b> {{ number_format($totalTj, 2, '.', '') }}
											</h3>
										</div>
										<div class="col-md-6">
											<h3><b>Ganancia Agente: $ {{ number_format($totalAgente, 2, '.', '') }}</b></h3>
										</div>

									</div>
								</div>

								<div class="data-table-toolbar">
									<div class="row">
										<div class="col-md-3">
											<h3><b>A Pagar:</b> {{ number_format($apagar, 2, '.', '') }}
											</h3>
										</div>
										<div class="col-md-3">
											<h3><b>Efectivo:</b> {{ $rendicion->importe_efectivo }}
											</h3>
										</div>
										<div class="col-md-3">
											<h3><b>Premios:</b> {{ $rendicion->importe_premios }}
											</h3>
										</div>
										<div class="col-md-3">
											<h3><b>Saldo:</b>
												@if($rendicion->importe_saldo <= 0)
											<span class="label label-success">{{ $rendicion->importe_saldo }}</span>
											@else
											<span class="label label-danger">{{ $rendicion->importe_saldo }}</span>
											@endif
											</h3>
										</div>

									</div>
								</div>

								@if ($rendicion->estado=='abierta')
								<div class="data-table-toolbar">
									<div class="row">
										<div class="col-md-4">
											<h3>Pagos</h3>
											{{ Form::open(array('route' => 'rendicions.storepagos')) }}
											{{ Form::hidden('rendicions_id', $rendicion->id, array('id' => 'rendicions_id', 'name' => 'rendicions_id')) }}
											{{ Form::text('importe_efectivo', $rendicion->importe_efectivo, array('id' =>'importe_efectivo', 'name' =>'importe_efectivo', 'class' => 'form-control input-lg', 'placeholder' => 'Efectivo...')) }}
											{{ Form::text('importe_premios', $rendicion->importe_premios, array('id' =>'importe_premios', 'name' =>'importe_premios', 'class' => 'form-control input-lg', 'placeholder' => 'Premios...')) }}
											{{ Form::submit('Calcular', array('class' => 'btn btn-primary')) }}
											{{ Form::close() }}
										</div>
									</div>
								</div>
								@endif

							</div>
						</div>
					</div>

				</div>







@stop
