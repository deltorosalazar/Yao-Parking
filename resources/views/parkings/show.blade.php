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
                        <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-desktop"></i> {{ $title }}
                    </li>
                </ol>
            </div>
        </div>

        @if (count($simulations) > 0)
            <div class="row">
                <div class="col-sm-3">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="parkings-table">
                            <thead>
                                <tr>
                                    <th>Simulación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($simulations as $simulation)
                                    <tr>
                                        <td>
                                            <a href="/simulations/show/{{ $id }}">
                                                {{ $simulation->simulation_id }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-9">
                    <canvas id="line-chart" width="800" height="450"></canvas>
                </div>
            </div>
        @else
            <div class="alert alert-dismissible alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4>Aviso!</h4>
                <p>Este parquedero no tiene simulaciones asociadas.</p>
            </div>

        @endif

    </div>


@endsection

@section('libraries')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>


    <script type="text/javascript">
        new Chart(document.getElementById("line-chart"), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($simluations_ids); ?>,
                datasets: [
                    {
                        data: <?php echo json_encode($total_by_simulations); ?>,
                        label: "Parqueadero #" + {{ $id }},
                        borderColor: 'rgba(255,99,132,1)',
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Ingresos del Parqueadero #' + {{ $id }} + ' por Simulación'
                }
            }
        });
    </script>

@endsection
