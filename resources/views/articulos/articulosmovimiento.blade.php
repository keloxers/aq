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
									{{ Form::open(array('route' => 'articulos.articulosmovimientosstore', 'class' => 'form-horizontal', 'role' => 'form', 'autocomplete' => 'off')) }}
										<div class="form-group">
											<label for="input-text" class="col-sm-2 control-label">Movimiento descripcion</label>
												<div class="col-sm-10">
													{{ Form::text('agente', '', array('id' =>'agente', 'name' =>'agente', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese un Agente')) }}
													{{ Form::hidden('agentes_id', '', array('id' => 'agentes_id', 'name' => 'agentes_id')) }}
												</div>
										</div>
										<div class="form-group">
											<label for="input-text" class="col-sm-2 control-label">Cuenta</label>
											<div class="col-sm-2">
												{{ Form::text('cantidad', '1', array('id' => 'cantidad', 'name' => 'cantidad', 'class' => 'form-control input-lg', 'placeholder' => 'Cantidad')) }}
											</div>

												<div class="col-sm-6">
													{{ Form::text('articulo', '', array('id' => 'articulo', 'name' => 'articulo', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese un articulo')) }}
													{{ Form::hidden('articulos_id', '', array('id' => 'articulos_id', 'name' => 'articulos_id')) }}
												</div>

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
						$("#agente").autocomplete({
								source: "/agentes/search",
								select: function( event, ui ) {
									$('#agentes_id').val( ui.item.id );

								}
							});
						$("#articulo").autocomplete({
								source: "/articulos/search",
								select: function( event, ui ) {
									$('#articulos_id').val( ui.item.id );

								}
							});
						});
				</script>

@stop
