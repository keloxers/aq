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

								<?php
									$debe=0;
									$haber=0;
									$saldo=0;
								?>


								<div class="table-responsive">
									<table data-sortable class="table table-hover table-striped">
										<thead>
											<tr>
												<th><div align="center">Fecha</div></th>
												<th><div align="center">Usuario</div></th>
												<th><div align="center">Cuenta</div></th>
												<th><div align="center">Movimiento</div></th>
												<th><div align="center">Debe</div></th>
												<th><div align="center">Haber</div></th>
												<th><div align="center">Saldo</div></th>
											</tr>
										</thead>

										<tbody>
											@if ($movimientos)
											@foreach ($movimientos as $movimiento)
											<tr>
												<td>{{ Carbon::parse($movimiento->created_at)->format('d/m/Y') }}</td>
												<td>{{ $movimiento->users->name }}</td>
												<td>{{ $movimiento->cuentas->cuenta }}</td>
												<td>
													@if (Auth::user()->tipo >= 2)
													<a href='/movimientos/{{ $movimiento->id }}/edit'>
													@endif

															{{ $movimiento->movimiento }}

													@if (Auth::user()->tipo >= 2)
														</a>
													@endif
												</td>
												<td><div align="right">{{ $movimiento->debe }}</div></td>
												<td><div align="right">{{ $movimiento->haber }}</div></td>
												<td></td>
												<?php
												$debe +=$movimiento->debe;
												$haber +=$movimiento->haber;
												 ?>
											</tr>
											@endforeach
											<?php
												$saldo = $haber - $debe;
											 ?>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td><div align="right">{{ number_format($debe, 2, '.', '') }}</div></td>
												<td><div align="right">{{ number_format($haber, 2, '.', '') }}</div></td>
												<td></td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td><div align="right">
													@if($saldo >= 0)
												<h3><span class="label label-success">{{ number_format($saldo, 2, '.', '') }}</span></h3>
												@else
												<h3><span class="label label-danger">{{ number_format($saldo, 2, '.', '') }}</span></h3>
												@endif
												</div></td>
											</tr>
										</tbody>
										@endif
									</table>
								</div>

							</div>
						</div>
					</div>

				</div>







@stop
