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
                    {{ $status['title'] }}
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  Dashboard
                    </li>
                    <li class="active">
                        <i class="fa fa-desktop"></i> {{ $status['title'] }}
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-offset-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos de la Simulación</h3>
                    </div>
                    <div class="panel-body">
                        <p>La Simulación fue:</p>
                        <p>
                            <b>Desde: </b>{{ $status['simulation_initial_date'] }}
                        </p>
                        <p>
                            <b>Hasta: </b>{{ $status['simulation_finish_date'] }}
                        </p>
                        <hr>
                        <p>La Simulación</p>
                        <p>
                            <b>Inició el: </b>{{ $status['initial_time'] }}
                        </p>
                        <p>
                            <b>Terminó el: </b>{{ $status['final_time'] }}
                        </p>
                        <p>
                            <b>Duración Total (En segundos): </b>{{ $status['total_duration'] }}
                        </p>
                        @if ($status['total_duration'] > 60)
                            <p>
                                <b>Duración Total (En minutos): </b> {{ ceil( $status['total_duration'] / 60) }}
                            </p>
                        @endif
                        @if ($status['total_duration'] > 3600)
                            <p>
                                <b>Duración Total (En horas): </b> {{ ceil( $status['total_duration'] / 3600) }}
                            </p>
                        @endif

                        <div class="form-group">
                            <a type="button" class="pull-right btn btn-primary" href="{{ url('/simulations ') }}">Ir a Simulaciones</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


@endsection

@section('libraries')


    <script type="text/javascript">
        $('[data-toggle="popover"]').popover({
            placement : 'bottom'
        });
    </script>

    {{-- <script type="text/javascript" src="/js/yao/simulations.js"></script> --}}

@endsection
