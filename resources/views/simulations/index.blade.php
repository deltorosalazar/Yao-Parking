@extends('layouts.dashboard')

@section('title')
    <title>YaoParking || {{ $title }}</title>
@endsection

@section('content')
    {{ csrf_field() }}
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    {{ $title }}
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="/simulations">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-desktop"></i> {{ session('status')['title'] }}
                    </li>
                </ol>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                <p>La Simulación fue:</p>
                <p>
                    <b>Desde: </b>{{ session('status')['initial_date'] }}
                </p>
                <p>
                    <b>Hasta: </b>{{ session('status')['final_date'] }}
                </p>
                <hr>
                <p>La Simulación</p>
                <p>
                    <b>Empezó el: </b>{{ session('status')['initial_time'] }}
                </p>
                <p>
                    <b>Terminó el: </b>{{ session('status')['final_time'] }}
                </p>
                <p>
                    <b>Duración Total (En minutos): </b>{{ session('status')['total_duration'] }}
                </p>
                @if (session('status')['total_duration'] > 60)
                    <p>
                        <b>Duración Total (En horas): </b> {{ ceil( session('status')['total_duration'] / 60) }}
                    </p>
                @endif
            </div>
        @endif
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Agregar Simulación</h3>
                    </div>
                    <div class="panel-body">
                        <form class="" action="/simulations/store" method="post">
                            {{ csrf_field() }}

                            <div class="bs-component start_date_error hidden">
                                <div class="alert alert-dismissible alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    {{-- <strong>Error!</strong> <a href="#" class="alert-link">Change a few things up</a> and try submitting again. --}}
                                    <strong class="myError">Error!</strong>
                                </div>
                                <div id="source-button" class="btn btn-primary btn-xs" style="display: none;">&lt; &gt;</div>
                            </div>

                            <div class="bs-component end_date_error hidden">
                                <div class="alert alert-dismissible alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    {{-- <strong>Error!</strong> <a href="#" class="alert-link">Change a few things up</a> and try submitting again. --}}
                                    <strong class="myError">Error!</strong>
                                </div>
                                <div id="source-button" class="btn btn-primary btn-xs" style="display: none;">&lt; &gt;</div>
                            </div>

                            <div class="form-group">
                                <label>Fecha de Inicio</label>
                                <input type="text" class="form-control" name="start_date" data-field="datetime" id="start_date" placeholder="Fecha de Inicio">

                            </div>
                            <div class="form-group">
                                <label>Fecha de Finalización</label>
                                <input type="text" class="form-control" name="finish_date" data-field="datetime" id="finish_date" placeholder="Fecha de Finalización" >
                            </div>
                            <div class="form-group">
                                <button type="submit" class="pull-right btn btn-primary" id="store-button">Iniciar Simulación</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="simulations-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Finalización</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($simulations as $simulation)
                                <tr id="role-{{ $simulation->id }}">
                                    <td>
                                        <a style="cursor: pointer" href="/simulations/show/{{ $simulation->id }}">
                                            {{ $simulation->id }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $simulation->start_date }}
                                    </td>
                                    <td>
                                        {{ $simulation->finish_date }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="badge">{{ count($total_parkings) }}</span>
                        Total de
                        <a href="{{ url('/parkings') }}">Parqueaderos</a>
                    </li>
                    <li class="list-group-item">
                        <span class="badge">{{ $total_vehicle_types }}</span>
                        Total de
                        <a href="{{ url('/vehicle_types') }}">Tipos de Vehículos</a>
                    </li>
                </ul>
            </div>
        </div>


        <div id="dtBox"></div>
    </div>


@endsection

@section('libraries')

    <script type="text/javascript" src="{{ URL::asset('js/DateTimePicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/DateTimePicker-i18n.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
			$("#dtBox").DateTimePicker({
                language: 'es',
                dateTimeFormat: 'yyyy-MM-dd hh:mm:ss',
                minTime: '06:00:00',
                maxTime: '23:00:00',
                setButtonContent: 'Seleccionar'
            });
		});
    </script>

    <script type="text/javascript">
        $('[data-toggle="popover"]').popover({
            placement : 'bottom'
        });
    </script>

    {{-- <script type="text/javascript" src="/js/yao/simulations.js"></script> --}}

@endsection
