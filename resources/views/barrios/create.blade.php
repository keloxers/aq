@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><a href="/barrios"><i class="icon-left"></i></a> <strong>{{ $title}}</h2>
								<div class="additional-btn">
									<a href="/barrios" class="hidden reload"><i class="icon-ccw-1"></i></a>
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
									{{ Form::open(array('route' => 'barrios.store', 'class' => 'form-horizontal', 'role' => 'form', 'autocomplete' => 'off')) }}
										<div class="form-group">
											<label for="input-text" class="col-sm-2 control-label">Barrio</label>
												<div class="col-sm-10">
													{{ Form::text('barrio', '', array('id' => 'barrio', 'name' => 'barrio', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese una barrio')) }}
												</div>
										</div>

										<div class="form-group">
											<label for="input-text" class="col-sm-2 control-label">Ciudad</label>
												<div class="col-sm-10">
													{{ Form::text('ciudad', '', array('id' =>'ciudad', 'name' =>'ciudad', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese una ciudad')) }}
													{{ Form::hidden('ciudads_id', '', array('id' => 'ciudads_id', 'name' => 'ciudads_id')) }}
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
