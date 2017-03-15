@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><a href="/ciudads"><i class="icon-left"></i></a> <strong>{{ $title}}</h2>
								<div class="additional-btn">
									<a href="/ciudads" class="hidden reload"><i class="icon-ccw-1"></i></a>
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
									{{ Form::open(array('url' => URL::to('ciudads/' . $ciudad->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}
										<div class="form-group">
												<label for="input-text" class="col-sm-2 control-label">Ciudad</label>
												<div class="col-sm-10">
													{{ Form::text('ciudad', $ciudad->ciudad, array('class' => 'form-control input-lg', 'placeholder'
													 => 'Ingrese una ciudad')) }}
													 {{ Form::hidden('id', $ciudad->id, array('id' => 'id', 'name' => 'id')) }}
												</div>
											</div>

											<div class="form-group">
													<label for="input-text" class="col-sm-2 control-label">Codigo Postal</label>
													<div class="col-sm-10">
														{{ Form::text('codigopostal', $ciudad->codigopostal, array('class' => 'form-control input-lg', 'placeholder'
														 => 'Ingrese una codigo postal')) }}

													</div>
												</div>

											<div class="form-group">
												<label for="input-text" class="col-sm-2 control-label">Provincia</label>
													<div class="col-sm-10">
														{{ Form::text('provincia', $provincia->provincia, array('id' =>'provincia', 'name' =>'provincia', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese una provincia')) }}
														{{ Form::hidden('provincias_id', $provincia->id, array('id' => 'provincias_id', 'name' => 'provincias_id')) }}
													</div>
											</div>


										</div>
										<div class="widget-content padding">
											<div class="form-group">
												{{ Form::submit('Modificar', array('class' => 'btn btn-primary')) }}
											</div>
										</div>

								</div>


							</div>
						</div>
					</div>



					<script>

						var jq = jQuery.noConflict();
						jq(document).ready( function(){


							$("#provincia").autocomplete({
									source: "/provincias/search",
									select: function( event, ui ) {
										$('#provincias_id').val( ui.item.id );

									}
								});


							});


					</script>



@stop
