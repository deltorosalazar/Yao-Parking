<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    @yield('title')

    <!-- Bootstrap Core CSS -->

    <link href="{{ URL::asset('/css/bootstrap3.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('/css/DateTimePicker.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" type="text/css" href="../css/DateTimePicker.css" /> --}}
    {{-- <link href="../css/bootstrap3.min.css" rel="stylesheet"> --}}


    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/sb-admin.css') }}" />
    {{-- <link href="../css/sb-admin.css" rel="stylesheet"> --}}

    <!-- Custom Fonts -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/font-awesome/css/font-awesome.min.css') }}" />
    {{-- <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> --}}


</head>

<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">Yao-Parking</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->name }} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-fw fa-power-off"></i> Cerrar Sesión
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="{{ Request::is('simulations') ? 'active' : '' }}">
                        <a href="{{ url('/simulations') }}"><i class="fa fa-fw fa-dashboard"></i> Simulaciones</a>
                    </li>
                    <li class="{{ Request::is('taxes') ? 'active' : '' }}">
                        <a href="{{ url('/taxes') }}"><i class="fa fa-fw fa-bar-chart-o"></i> Impuestos</a>
                    </li>
                    <li class="{{ Request::is('users') || Request::is('roles') ? 'active' : '' }}">
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo" class="{{ !Request::is('users') || !Request::is('roles') ? 'collapsed' : '' }}" aria-expanded="{{ Request::is('users') || Request::is('roles') ? 'true' : '' }}"><i class="fa fa-fw fa-arrows-v"></i> Gestión de Usuarios <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="{{ url('/users') }}"><i class="fa fa-fw fa-user"></i> Usuarios</a>
                            </li>
                            <li>
                                <a href="{{ url('/roles') }}"><i class="fa fa-fw fa-users"></i> Roles</a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Request::is('prices') ? 'active' : '' }}">
                        <a href="{{ url('/prices') }}"><i class="fa fa-fw fa-usd"></i> Tarifas</a>
                    </li>
                    <li class="{{ Request::is('vehicle_types') ? 'active' : '' }}">
                        <a href="{{ url('/vehicle_types') }}"><i class="fa fa-fw fa-car"></i> Tipos de Vehículo</a>
                    </li>
                    <li class="{{ Request::is('parkings/*') || Request::is('parkings') ? 'active' : '' }}">
                        <a href="{{ url('/parkings') }}"><i class="fa fa-fw fa-table"></i> Parqueaderos</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper">
            @yield('content')
        </div>
    </div>

    {{-- <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script> --}}

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    @yield('libraries')



</body>

</html>
