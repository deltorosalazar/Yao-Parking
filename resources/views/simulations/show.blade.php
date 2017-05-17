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
                        <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-desktop"></i> {{ $title }}
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="well">
                    <p><b>Fecha de Inicio: </b>{{ $simulation->start_date }}</p>
                    <p><b>Fecha de Finalización: </b>{{ $simulation->finish_date }} </p>
                </div>
            </div>
        </div>
        <h1 class="page-header">
            10 Parqueaderos que más recaudaron
        </h1>
        <div class="row">
            @foreach ($vehicle_types_earnings as $key => $vehicle_type)
                <div class="col-sm-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ $vehicle_type['name'] }}</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped" id="simulations-table">
                                    <thead>
                                        <tr>
                                            <th>Parqueadero</th>
                                            <th>Total Recaudado</th>
                                            @foreach ($taxes as $tax)
                                                <th>{{ $tax->name }} (-{{ $tax->percentage }}%)</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vehicle_type['earnings'] as $earning)
                                            <tr>
                                                <td>
                                                    <a
                                                    data-toggle="popover"
                                                    title="<b>Detalles</b>"
                                                    data-html="true"
                                                    data-content="
                                                        <b>ID:</b> {{ $earning->parking_id }} <br>
                                                        {{-- <b>Fecha de Creación:</b> {{ $simulation->created_at }} <br>
                                                        <b>Última Modificación:</b> {{ $simulation->updated_at }} --}}
                                                        "
                                                    style="cursor: pointer">
                                                        {{ $earning->parking_id }}
                                                    </a>
                                                </td>
                                                <td>
                                                    $ {{ $earning->total }}

                                                </td>
                                                @foreach ($taxes as $tax)
                                                    <td>
                                                        $ {{ round($earning->total * ($tax->percentage / 100)) }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        <tr class="success">
                                            <td>
                                                <b>TOTAL</b>
                                            </td>

                                            <td>$ {{ $total_vehicle_types_earnings[$vehicle_type['id']] }}</td>


                                            @foreach ($taxes as $tax)
                                                <td>
                                                    $ {{ round($earning->total * ($tax->percentage / 100)) }}
                                                </td>
                                            @endforeach
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Los 10 Mejores Parqueaderos</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="simulations-table">
                                <thead>
                                    <tr>
                                        <th>Parqueadero</th>
                                        <th>Total Recaudado</th>
                                        @foreach ($taxes as $tax)
                                            <th>{{ $tax->name }} (-{{ $tax->percentage }}%)</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($earnings as $earning)
                                        <tr>
                                            <td>
                                                <a
                                                data-toggle="popover"
                                                title="<b>Detalles</b>"
                                                data-html="true"
                                                data-content="
                                                    <b>ID:</b> {{ $earning->parking_id }} <br>
                                                    {{-- <b>Fecha de Creación:</b> {{ $simulation->created_at }} <br>
                                                    <b>Última Modificación:</b> {{ $simulation->updated_at }} --}}
                                                    "
                                                style="cursor: pointer">
                                                    {{ $earning->parking_id }}
                                                </a>
                                            </td>
                                            <td>
                                                $ {{ $earning->total }}

                                            </td>
                                            @foreach ($taxes as $tax)
                                                <td>
                                                    $ {{ round($earning->total * ($tax->percentage / 100)) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    <tr class="success">
                                        <td>
                                            <b>TOTAL</b>
                                        </td>
                                        <td>$ {{ $total_earnings }}</td>
                                        @foreach ($taxes as $tax)
                                            <td>
                                                $ {{ round($total_earnings * ($tax->percentage / 100)) }}
                                            </td>
                                        @endforeach
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">Utilidades Mensuales por Parqueadero</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group col-md-6">
                                    <label>Parqueadero</label>
                                    <div>
                                        <select class="form-control" id="monthly_parking" name="monthly_parking">
                                            @foreach ($parkings as $parking)
                                                <option value="{{ $parking->parking_id }}">{{ $parking->parking_id }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Año</label>
                                    <div>
                                        <select class="form-control" id="monthly_year" name="monthly_year">
                                            @foreach ($years as $year)
                                                <option value="{{ $year->y }}">{{ $year->y }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="button" class="pull-right btn btn-warning" id="monthly_button">Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="row monthly_table">
                            {{-- <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped" id="simulations-table">
                                        <thead>
                                            <tr>
                                                <th>Mes</th>
                                                <th>Total Recaudado</th>
                                                @foreach ($taxes as $tax)
                                                    <th>{{ $tax->name }} (-{{ $tax->percentage }}%)</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($earnings as $earning)
                                                <tr>
                                                    <td>
                                                        {{ $earning->parking_id }}
                                                    </td>
                                                    <td>
                                                        $ {{ $earning->total }}

                                                    </td>
                                                    @foreach ($taxes as $tax)
                                                        <td>
                                                            $ {{ round($earning->total * ($tax->percentage / 100)) }}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                            <tr class="warning">
                                                <td>
                                                    <b>TOTAL</b>
                                                </td>
                                                <td>$ {{ $total_earnings }}</td>
                                                @foreach ($taxes as $tax)
                                                    <td>
                                                        $ {{ round($total_earnings * ($tax->percentage / 100)) }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-md-4">
                <canvas id="myChart" width="100" height="100"></canvas>
            </div>


        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Parqueaderos para mejorar su espacio</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="badge">14</span>
                                Cras justo odio
                            </li>
                            <li class="list-group-item">
                                <span class="badge">2</span>
                                Dapibus ac facilisis in
                            </li>
                        </ul>

                    </div>
                </div>
            </div>

        </div>





    </div>


@endsection

@section('libraries')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>

    <script type="text/javascript" src="/js/yao/monthly_earnings.js"></script>

    <script type="text/javascript">
        $('[data-toggle="popover"]').popover({
            placement : 'bottom'
        });
    </script>



    <script>
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($movements_names); ?>,
                datasets: [{
                    label: 'Cantidad',
                    data: <?php echo json_encode($movements_count); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Total de Entradas y Salidas Durante la Simulación'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>

@endsection
