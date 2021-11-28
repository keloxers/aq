@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><a href="/articulos"><i class="icon-left"></i></a> <strong>{{ $title}}</h2>
								<div class="additional-btn">
									<a href="/articulos" class="hidden reload"><i class="icon-ccw-1"></i></a>
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
									{{ Form::open(array('route' => 'articulos.store', 'class' => 'form-horizontal', 'role' => 'form', 'autocomplete' => 'off')) }}
										<div class="form-group">
												<div class="col-sm-6">
													{{ Form::text('articulo', '', array('id' => 'articulo', 'name' => 'articulo', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese el nombre del articulo')) }}
												</div>
												<div class="col-sm-6">
													{{ Form::text('cuenta', '', array('id' => 'cuenta', 'name' => 'cuenta', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese una cuenta asociada')) }}
													{{ Form::hidden('cuentas_id', '', array('id' => 'cuentas_id', 'name' => 'cuentas_id')) }}
												</div>

										</div>

										<div class="form-group">
											<div class="col-sm-4">
												{{ Form::text('precio', '', array('id' => 'precio', 'name' => 'precio', 'class' => 'form-control input-lg', 'placeholder' => 'Precio')) }}
											</div>
											<div class="col-sm-4">
												{{ Form::text('stock_actual', '', array('id' => 'stock_actual', 'name' => 'stock_actual', 'class' => 'form-control input-lg', 'placeholder' => 'Stock Actual')) }}
											</div>
											<div class="col-sm-4">
												{{ Form::text('stock_minimo', '', array('id' => 'stock_minimo', 'name' => 'stock_minimo', 'class' => 'form-control input-lg', 'placeholder' => 'Stock Minimo')) }}
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
						$("#cuenta").autocomplete({
								source: "/cuentas/search",
								select: function( event, ui ) {
									$('#cuentas_id').val( ui.item.id );

								}
							});
						});
				</script>


@stop
