@extends('layouts.dashboard')

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
                        <i class="fa fa-dashboard"></i>  Dashboard
                    </li>
                    <li class="active">
                        <i class="fa fa-desktop"></i> {{ $title }}
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-offset-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos de la Simulación</h3>
                    </div>
                    <div class="panel-body">
                        <p>La Simulación fue:</p>
                        <p>
                            <b>Desde: </b>{{ $simulation_initial_date }}
                        </p>
                        <p>
                            <b>Hasta: </b>{{ $simulation_initial_date }}
                        </p>
                        <hr>
                        <p>La Simulación</p>
                        <p>
                            <b>Empezó el: </b>{{ $initial_time }}
                        </p>
                        <p>
                            <b>Terminó el: </b>{{ $final_time }}
                        </p>
                        <p>
                            <b>Duración Total (En minutos): </b> {{ $total_duration }}
                        </p>
                        @if ($total_duration > 60)
                            <p>
                                <b>Duración Total (En horas): </b> {{ ceil($total_duration / 60) }}
                            </p>
                        @endif
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
