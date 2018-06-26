@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link href="/assets/libs/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />


<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><a href="/"><i class="icon-left"></i></a> <strong>{{ $title}}</h2>
								<div class="additional-btn">
									<a href="/rendicions" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							@if(count(session('errors')) > 0)
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
									{{ Form::open(array('route' => 'planillas.estadoscuenta', 'class' => 'form-horizontal', 'role' => 'form', 'autocomplete' => 'off')) }}
										<div class="form-group">

											<div class="form-group">
												<label for="input-text" class="col-sm-2 control-label">Cuenta</label>
													<div class="col-sm-6">
														{{ Form::text('cuenta', '', array('id' => 'cuenta', 'name' => 'cuenta', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese una cuenta')) }}
														{{ Form::hidden('cuentas_id', '', array('id' => 'cuentas_id', 'name' => 'cuentas_id')) }}
													</div>
													<div class="col-sm-2">

													</div>
													<div class="col-sm-2">
													</div>
											</div>

										</div>
										<div class="widget-content padding">
											<div class="form-group">
												{{ Form::submit('Ver', array('class' => 'btn btn-primary')) }}
											</div>
										</div>

										{{ Form::close() }}
								</div>


							</div>
						</div>
					</div>

				</div>


				<div class="row">
									<div class="col-md-12">
										<div class="widget">
											<div class="widget-header transparent">
												<h2><a href="/"><i class="icon-left"></i></a> <strong>Ver todas las cuentas</h2>
												<div class="additional-btn">
													<a href="/rendicions" class="hidden reload"><i class="icon-ccw-1"></i></a>
													<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
													<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
												</div>
											</div>

											<div class="widget-content">

												<div class="widget-content padding">

													<div class="row">

														<div class="col-md-2">
															<div class="toolbar-btn-action">
																<a href="/estadoscuenta/todasdeudas" class="btn btn-success"> Ver todas las deudas </a>
															</div>
														</div>
													</div>


												</div>


											</div>
										</div>
									</div>

								</div>



				<script>
					var jq = jQuery.noConflict();
					jq(document).ready( function(){
						$("#cuenta").autocomplete({
								source: "/cuentas/search",
								select: function( event, ui ) {
									$('#cuentas_id').val( ui.item.id );

								}
							});
						});
				</script>

<script src="assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
@stop
