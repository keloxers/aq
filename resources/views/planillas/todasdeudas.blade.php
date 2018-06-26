@extends('layouts.app')

@section('content')
<?php
use Carbon\Carbon;
use App\Movimiento;
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
												<th><div >Cuenta</div></th>
												<th><div align="right">Saldo</div></th>
											</tr>
										</thead>

										<tbody>
											@if ($cuentas)
												@foreach ($cuentas as $cuenta)
												<tr>
													<td>{{ $cuenta->cuenta }}</td>
													<?php
														$debe=Movimiento::where('cuentas_id', $cuenta->id)->sum('debe');
														$haber=Movimiento::where('cuentas_id', $cuenta->id)->sum('haber');
														$saldo = $haber - $debe;
													 ?>
													<td><div align="right">{{ number_format($saldo, 2, '.', '') }}</div></td>
												</tr>
												@endforeach
										</tbody>
										@endif
									</table>
								</div>

							</div>
						</div>
					</div>

				</div>







@stop
