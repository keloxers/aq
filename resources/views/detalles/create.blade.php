@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><a href="/detalles/{{$rendicion->id}}/detalles"><i class="icon-left"></i></a> <strong>{{ $title}}</h2>
								<div class="additional-btn">
									<a href="/detalles/{{$rendicion->id}}/detalles" class="hidden reload"><i class="icon-ccw-1"></i></a>
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
									{{ Form::open(array('route' => 'detalles.store', 'class' => 'form-horizontal', 'role' => 'form', 'autocomplete' => 'off')) }}
									{{ Form::hidden('rendicions_id', $rendicion->id, array('id' => 'rendicions_id', 'name' => 'rendicions_id')) }}
									@if($agentesjuegos)
															@foreach ($agentesjuegos as $agentesjuego)
																	<div class="form-group">
																		<label for="input-text" class="col-sm-2 control-label">{{ $agentesjuego->juegos->juego }}</label>
																			<div class="col-sm-3">
																				<input id="{{ $agentesjuego->juegos->juego }}" name="{{ $agentesjuego->juegos->juego }}" class="form-control input-lg" placeholder="" type="text" value="">
																			</div>
																	</div>
															@endforeach
									@endif
									<div class="form-group">
										<label for="input-text" class="col-sm-2 control-label">Premios</label>
											<div class="col-sm-3">
												<input id="premios" name="premios" class="form-control input-lg" placeholder="Premios a descontar" type="text" value="">
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
		$("#ciudad").autocomplete({
				source: "/ciudads/search",
				select: function( event, ui ) {
					$('#ciudads_id').val( ui.item.id );

				}
			});
		});
</script>


@stop
