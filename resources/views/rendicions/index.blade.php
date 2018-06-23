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
									<a href="/rendicions" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							<div class="widget-content">
								<div class="data-table-toolbar">
									<div class="row">
										<div class="col-md-4">
											{{ Form::open(array('route' => 'rendicions.finder')) }}
											<input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar...">
											{{ Form::close() }}
										</div>
										<div class="col-md-8">
											<div class="toolbar-btn-action">
												<a href="/rendicions/create" class="btn btn-success"><i class="fa fa-plus-circle"></i> Nuevo</a>
											</div>
										</div>
									</div>
								</div>

								<div class="table-responsive">
									<table data-sortable class="table table-hover table-striped">
										<thead>
											<tr>
												<th>Fecha</th>
												<th>Usuario</th>
												<th>Agente</th>
												<th>Saldo</th>
												<th>Estado</th>
												<th>Acción</th>
											</tr>
										</thead>

										<tbody>
											@if ($rendicions)
											@foreach ($rendicions as $rendicion)
											<tr>
												<td>{{ Carbon::parse($rendicion->fecha)->format('d/m/Y') }}</td>
												<td>{{ $rendicion->users->name }}</td>
												<td>{{ $rendicion->agentes->agente }}</td>
												<td>{{ $rendicion->importe_saldo }}</td>
												<td>
													@if($rendicion->estado=='abierta')
													<span class="label label-success">{{ $rendicion->estado }}</span>
													@elseif ($rendicion->estado=='cerrada')
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
														@if($rendicion->estado=='abierta')
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
									{{ $rendicions->links() }}
								</div>
							</div>
						</div>
					</div>

				</div>







@stop
