@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><a href="/agentes"><i class="icon-left"></i></a> <strong>{{ $title}}</h2>
								<div class="additional-btn">
									<a href="/agentes" class="hidden reload"><i class="icon-ccw-1"></i></a>
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
									{{ Form::open(array('route' => 'agentes.storeagentesjuegos', 'class' => 'form-horizontal', 'role' => 'form', 'autocomplete' => 'off')) }}
									{{ Form::hidden('agentes_id', $agente->id, array('id' => 'agentes_id', 'name' => 'agentes_id')) }}
										<div class="form-group">
											<label for="input-text" class="col-sm-2 control-label">Juego</label>
												<div class="col-sm-10">
													{{ Form::text('juego', '', array('id' =>'juego', 'name' =>'juego', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese juego')) }}
													{{ Form::hidden('juegos_id', '', array('id' => 'juegos_id', 'name' => 'juegos_id')) }}
												</div>
										</div>

										<div class="form-group">
											<label for="input-text" class="col-sm-2 control-label">Porcentaje Agencia</label>
												<div class="col-sm-3">
													{{ Form::text('porcentaje_agencia', '', array('id' => 'porcentaje_agencia', 'name' => 'porcentaje_agencia', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese porcentaje Agencia')) }}
												</div>
										</div>

										<div class="form-group">
											<label for="input-text" class="col-sm-2 control-label">Porcentaje Agente</label>
												<div class="col-sm-3">
													{{ Form::text('porcentaje_agente', '', array('id' => 'porcentaje_agente', 'name' => 'porcentaje_agente', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese porcentaje Agente')) }}
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
						$("#juego").autocomplete({
								source: "/juegos/search",
								select: function( event, ui ) {
									$('#juegos_id').val( ui.item.id );

								}
							});
						});
				</script>


@stop
