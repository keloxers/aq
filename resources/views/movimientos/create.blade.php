@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><a href="/movimientos"><i class="icon-left"></i></a> <strong>{{ $title}}</h2>
								<div class="additional-btn">
									<a href="/movimientos" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							@if(session('errors')!=null && count(session('errors')) > 0)
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
									{{ Form::open(array('route' => 'movimientos.store', 'class' => 'form-horizontal', 'role' => 'form', 'autocomplete' => 'off')) }}
										<div class="form-group">
											<label for="input-text" class="col-sm-2 control-label">Movimiento descripcion</label>
												<div class="col-sm-10">
													{{ Form::text('movimiento', '', array('id' => 'movimiento', 'name' => 'movimiento', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese una movimiento')) }}
												</div>
										</div>
										<div class="form-group">
											<label for="input-text" class="col-sm-2 control-label">Cuenta</label>
												<div class="col-sm-4">
													{{ Form::text('cuenta', '', array('id' => 'cuenta', 'name' => 'cuenta', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese una cuenta')) }}
													{{ Form::hidden('cuentas_id', '', array('id' => 'cuentas_id', 'name' => 'cuentas_id')) }}
												</div>
												<div class="col-sm-2">
													{{ Form::text('debe', '0', array('id' => 'debe', 'name' => 'debe', 'class' => 'form-control input-lg', 'placeholder' => 'Pesos debe')) }}
												</div>
												<div class="col-sm-2">
													{{ Form::text('haber', '0', array('id' => 'haber', 'name' => 'haber', 'class' => 'form-control input-lg', 'placeholder' => 'Pesos haber')) }}
												</div>
												@if (Auth::user()->tipo >= 2)
	                      <div class="col-sm-2">
	                        <input type="checkbox" class="ios-switch ios-switch-success ios-switch-sm" name="enplanilla" id="enplanilla" checked/><br>
													en planilla
	                      </div>
												@endif


										</div>

										</div>
										<div class="widget-content padding">
											<div class="form-group">
												{{ Form::submit('Agregar', array('class' => 'btn btn-primary')) }}
											</div>
										</div>

										{{ Form::close() }}
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


@stop
