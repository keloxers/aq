<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Agencia74 | Admin</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
            <meta name="apple-mobile-web-app-capable" content="yes" />
            <meta name="description" content="">
            <meta name="keywords" content="coco bootstrap template, coco admin, bootstrap,admin template, bootstrap admin,">
            <meta name="author" content="Huban Creative">

            <!-- Base Css Files -->
            <link href="/assets/libs/jqueryui/ui-lightness/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
            <link href="/assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
            <link href="/assets/libs/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
            <link href="/assets/libs/fontello/css/fontello.css" rel="stylesheet" />
            <link href="/assets/libs/animate-css/animate.min.css" rel="stylesheet" />
            <link href="/assets/libs/nifty-modal/css/component.css" rel="stylesheet" />
            <link href="/assets/libs/magnific-popup/magnific-popup.css" rel="stylesheet" />
            <link href="/assets/libs/ios7-switch/ios7-switch.css" rel="stylesheet" />
            <link href="/assets/libs/pace/pace.css" rel="stylesheet" />
            <link href="/assets/libs/sortable/sortable-theme-bootstrap.css" rel="stylesheet" />
            <link href="/assets/libs/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
            <link href="/assets/libs/jquery-icheck/skins/all.css" rel="stylesheet" />
            <!-- Code Highlighter for Demo -->
            <link href="/assets/libs/prettify/github.css" rel="stylesheet" />

                    <!-- Extra CSS Libraries Start -->
                    <link href="/assets/libs/rickshaw/rickshaw.min.css" rel="stylesheet" type="text/css" />
                    <link href="/assets/libs/morrischart/morris.css" rel="stylesheet" type="text/css" />
                    <link href="/assets/libs/jquery-jvectormap/css/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
                    <link href="/assets/libs/jquery-clock/clock.css" rel="stylesheet" type="text/css" />
                    <link href="/assets/libs/bootstrap-calendar/css/bic_calendar.css" rel="stylesheet" type="text/css" />
                    <link href="/assets/libs/sortable/sortable-theme-bootstrap.css" rel="stylesheet" type="text/css" />
                    <link href="/assets/libs/jquery-weather/simpleweather.css" rel="stylesheet" type="text/css" />
                    <link href="/assets/libs/bootstrap-xeditable/css/bootstrap-editable.css" rel="stylesheet" type="text/css" />
                    <link href="/assets/css/style.css" rel="stylesheet" type="text/css" />
                    <!-- Extra CSS Libraries End -->
            <link href="/assets/css/style-responsive.css" rel="stylesheet" />

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
            <![endif]-->

            <link rel="shortcut icon" href="/assets/img/favicon.ico">
            <link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png" />
            <link rel="apple-touch-icon" sizes="57x57" href="/assets/img/apple-touch-icon-57x57.png" />
            <link rel="apple-touch-icon" sizes="72x72" href="/assets/img/apple-touch-icon-72x72.png" />
            <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-touch-icon-76x76.png" />
            <link rel="apple-touch-icon" sizes="114x114" href="/assets/img/apple-touch-icon-114x114.png" />
            <link rel="apple-touch-icon" sizes="120x120" href="/assets/img/apple-touch-icon-120x120.png" />
            <link rel="apple-touch-icon" sizes="144x144" href="/assets/img/apple-touch-icon-144x144.png" />
            <link rel="apple-touch-icon" sizes="152x152" href="/assets/img/apple-touch-icon-152x152.png" />
        </head>
        <body class="fixed-left">
            <!-- Modal Start -->
            	<!-- Modal Task Progress -->


    	<!-- Modal Logout -->
    	<div class="md-modal md-just-me" id="logout-modal">
    		<div class="md-content">
    			<h3>Confirmacion de <strong>salida</strong></h3>
    			<div>
    				<p class="text-center"> ¿Seguro desea cerrar la sesión de este sistema ?</p>
    				<p class="text-center">
    				<button class="btn btn-danger md-close">No!</button>
    				<a href="/logout" class="btn btn-success md-close">Si, estoy seguro</a>
    				</p>
    			</div>
    		</div>
    	</div>        <!-- Modal End -->
    	<!-- Begin page -->
    	<div id="wrapper">

    <!-- Top Bar Start -->
    <div class="topbar">
            <div class="topbar-left">
                <div class="logo">
                    <h1><a href="/"><img src="/assets/img/logo.png" alt="Logo"></a></h1>
                </div>
                @if (!Auth::guest())
                  <button class="button-menu-mobile open-left">
                  <i class="fa fa-bars"></i>
                @endif
                </button>
            </div>
        <!-- Button mobile view to collapse sidebar menu -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-collapse2">

                    <ul class="nav navbar-nav navbar-right top-navbar">

                        <li class="dropdown iconify hide-phone"><a href="#" onclick="javascript:toggle_fullscreen()"><i class="icon-resize-full-2"></i></a></li>

                        @if (Auth::guest())
                            <!-- <li><a href="{{ url('/login') }}">Login</a></li> -->
                            <li><a href="{{ url('/register') }}">Registrarse</a></li>
                        @else
                            <li class="dropdown topbar-profile">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="rounded-image topbar-profile-image"><img src="/images/users/user-35.jpg"></span> {{ Auth::user()->name }} <i class="fa fa-caret-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Perfil</a></li>
                                    @if (Auth::user()->isAdmin)
                                    <li><a href="#">Admin</a></li>
                                    @endif
                                    <li class="divider"></li>
                                    <li><a class="md-trigger" data-modal="logout-modal"><i class="icon-logout-1"></i> Logout</a></li>
                                </ul>
                            </li>
                        @endif


                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
    </div>
    <!-- Top Bar End -->
    		    <!-- Left Sidebar Start -->
            @if (!Auth::guest())




            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">


                    <!--- Divider -->
                    <div class="clearfix"></div>
                    <hr class="divider" />
                    <div class="clearfix"></div>
                    <!--- Divider -->

                    <div id="sidebar-menu">
                        <ul>
                          <li><a href='/'>
                            <i class='icon-home-3'></i>
                              <span>Home</span>
                              <span class="pull-right">
                              </a>
                          </li>




                            <li class='has_sub'>
                                  <a href='javascript:void(0);'>
                                      <i class='fa fa-cogs'></i>
                                      <span>Configuracion</span>
                                      <span class="pull-right"><i class="fa fa-angle-down"></i></span>
                                  </a>
                              <ul>
                                <!-- <li><a href='maintenance.html'><span>Maintenance</span></a></li> -->

                              <li class='has_sub'>
                                  <a href='javascript:void(0);'>
                                      <i class='fa fa-table'></i>
                                      <span>Tablas</span>
                                      <span class="pull-right">
                                            <i class="fa fa-angle-down"></i>
                                      </span>
                                  </a>
                                  <ul>
                                    <li><a href='/agentes'><span>Agentes</span></a></li>
                                    <li><a href='/cuentas'><span>Cuentas</span></a></li>
                                    <li><a href='/juegos'><span>Juegos</span></a></li>
                                  </ul>
                              </li>
                            </ul>
                            <li><a href='/rendicions'>
                              <i class='glyphicon glyphicon-shopping-cart'></i>
                                <span>Rendicion</span>
                                <span class="pull-right">
                                </a>
                            </li>

                            <li><a href='/planillas'>
                              <i class='glyphicon glyphicon-list-alt'></i>
                                <span>Planillas</span>
                                <span class="pull-right">
                                </a>
                            </li>
                            <li><a href='/movimientos'>
                              <i class='glyphicon glyphicon-list-alt'></i>
                                <span>Movimientos</span>
                                <span class="pull-right">
                                </a>
                            </li>
                            <li><a href='/estadoscuenta'>
                              <i class='glyphicon glyphicon-list-alt'></i>
                                <span>Estado de cuenta</span>
                                <span class="pull-right">
                                </a>
                            </li>




                            <div class="clearfix"></div>
                            </ul>
                    </div>
                <div class="clearfix"></div>

                <br><br><br>
            </div>
            </div>
                        @endif
            <!-- Left Sidebar End -->		    <!-- Right Sidebar Start -->

    		<!-- Start right content -->
            <div class="content-page">
    			<!-- ============================================================== -->
    			<!-- Start Content here -->
    			<!-- ============================================================== -->
                <div class="content">
                      @yield('content')
    				    </div>

            </div>
    			<!-- ============================================================== -->
    			<!-- End content here -->
    			<!-- ============================================================== -->

            </div>
    		<!-- End right content -->

    	</div>
    	<!-- End of page -->
    		<!-- the overlay modal element -->
    	<div class="md-overlay"></div>
    	<!-- End of eoverlay modal -->
    	<script>
    		var resizefunc = [];
    	</script>
    	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    	<script src="/assets/libs/jquery/jquery-1.11.1.min.js"></script>
    	<script src="/assets/libs/bootstrap/js/bootstrap.min.js"></script>
    	<script src="/assets/libs/jqueryui/jquery-ui-1.10.4.custom.min.js"></script>
    	<script src="/assets/libs/jquery-ui-touch/jquery.ui.touch-punch.min.js"></script>
    	<script src="/assets/libs/jquery-detectmobile/detect.js"></script>
    	<script src="/assets/libs/jquery-animate-numbers/jquery.animateNumbers.js"></script>
    	<script src="/assets/libs/ios7-switch/ios7.switch.js"></script>
    	<script src="/assets/libs/fastclick/fastclick.js"></script>
    	<script src="/assets/libs/jquery-blockui/jquery.blockUI.js"></script>
    	<script src="/assets/libs/bootstrap-bootbox/bootbox.min.js"></script>
    	<script src="/assets/libs/jquery-slimscroll/jquery.slimscroll.js"></script>
    	<script src="/assets/libs/jquery-sparkline/jquery-sparkline.js"></script>
    	<script src="/assets/libs/nifty-modal/js/classie.js"></script>
    	<script src="/assets/libs/nifty-modal/js/modalEffects.js"></script>
    	<script src="/assets/libs/sortable/sortable.min.js"></script>
    	<script src="/assets/libs/bootstrap-fileinput/bootstrap.file-input.js"></script>
    	<script src="/assets/libs/bootstrap-select/bootstrap-select.min.js"></script>
    	<script src="/assets/libs/bootstrap-select2/select2.min.js"></script>
    	<script src="/assets/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
    	<script src="/assets/libs/pace/pace.min.js"></script>
    	<script src="/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    	<script src="/assets/libs/jquery-icheck/icheck.min.js"></script>

    	<!-- Demo Specific JS Libraries -->
    	<script src="/assets/libs/prettify/prettify.js"></script>

    	<script src="/assets/js/init.js"></script>
    	<!-- Page Specific JS Libraries -->
    	<script src="/assets/libs/d3/d3.v3.js"></script>
    	<script src="/assets/libs/rickshaw/rickshaw.min.js"></script>
    	<script src="/assets/libs/raphael/raphael-min.js"></script>
    	<script src="/assets/libs/morrischart/morris.min.js"></script>
    	<script src="/assets/libs/jquery-knob/jquery.knob.js"></script>
    	<script src="/assets/libs/jquery-jvectormap/js/jquery-jvectormap-1.2.2.min.js"></script>
    	<script src="/assets/libs/jquery-jvectormap/js/jquery-jvectormap-us-aea-en.js"></script>
    	<script src="/assets/libs/jquery-clock/clock.js"></script>
    	<script src="/assets/libs/jquery-easypiechart/jquery.easypiechart.min.js"></script>
    	<script src="/assets/libs/jquery-weather/jquery.simpleWeather-2.6.min.js"></script>
    	<script src="/assets/libs/bootstrap-xeditable/js/bootstrap-editable.min.js"></script>
    	<script src="/assets/libs/bootstrap-calendar/js/bic_calendar.min.js"></script>
    	<script src="/assets/js/apps/calculator.js"></script>
    	<script src="/assets/js/apps/todo.js"></script>
    	<script src="/assets/js/apps/notes.js"></script>
    	<script src="/assets/js/pages/index.js"></script>
    	</body>
    </html>
