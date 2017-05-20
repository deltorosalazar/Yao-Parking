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
                        <i class="fa fa-desktop"></i> {{ $title }}
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Agregar Parqueadero</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <button type="button" class="pull-right btn btn-primary" id="store-button">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="parkings-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parkings as $parking)
                                <tr id="parking-{{ $parking->id }}">
                                    <td>
                                        <a
                                        data-toggle="popover"
                                        title="<b>Detalles</b>"
                                        data-html="true"
                                        data-content="
                                            <b>Fecha de Creación:</b> {{ $parking->created_at }} <br>
                                            <b>Última Modificación:</b> {{ $parking->updated_at }}"
                                        {{-- style="cursor: pointer"> --}}
                                        href="/parkings/show/{{ $parking->id }}">
                                            {{ $parking->id }}
                                        </a>
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            data-id="{{ $parking->id }}"
                                            class="pull-right state-button change-state-{{ $parking->id }}
                                            @if ($parking->active == 1)
                                                btn btn-danger"
                                                >Desactivar
                                            @else
                                                pull-right btn btn-success"
                                                >Activar
                                            @endif
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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

    <script type="text/javascript" src="/js/yao/parkings.js"></script>

@endsection
