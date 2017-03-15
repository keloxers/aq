@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><a href="/cuentas"><i class="icon-left"></i></a> <strong>{{ $title}}</h2>
								<div class="additional-btn">
									<a href="/cuentas" class="hidden reload"><i class="icon-ccw-1"></i></a>
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
									{{ Form::open(array('url' => URL::to('cuentas/' . $cuenta->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}

									<div class="form-group">
										<label for="input-text" class="col-sm-2 control-label">Cuenta</label>
											<div class="col-sm-10">
												{{ Form::text('cuenta', $cuenta->cuenta, array('id' => 'cuenta', 'name' => 'cuenta', 'class' => 'form-control input-lg', 'placeholder' => 'Ingrese una cuenta')) }}
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



@stop
