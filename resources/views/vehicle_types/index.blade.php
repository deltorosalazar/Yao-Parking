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

        <div class="row">
            <div class="col-sm-5">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Agregar Tipo de Vehículo</h3>
                    </div>
                    <div class="panel-body">
                        @if ($prices->count() > 0)
                            <div class="form-group">
                                <label>Nombre</label>
                                <input disabled class="form-control" name="vehicle-type-name" id="vehicle-type-name" placeholder="Nombre del Tipo de Vehículo">
                            </div>
                            <div id="vehicle-type-prices">
                                @foreach ($prices as $price)
                                    <div class="form-group">
                                        <label>{{ $price->name }}</label>
                                        <input disabled class="form-control" name="{{ $price->id }}" placeholder="Valor {{ $price->name }} ($)">
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <button disabled type="button" class="pull-right btn btn-primary" id="store-button">Agregar</button>
                            </div>
                        @else
                            <a href="{{ url('/prices') }}">
                                <span class="label label-danger">No existen Tarifas.</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="vehicle-types-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                @foreach ($prices as $price)
                                    <th>
                                        {{ $price->name }}
                                    </th>
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehicleTypes as $vehicleType)
                                <tr id="vehicle-type-{{ $vehicleType->id }}">
                                    <td>
                                        <a
                                        data-toggle="popover"
                                        title="<b>Detalles</b>"
                                        data-html="true"
                                        data-content="
                                            <b>ID:</b> {{ $vehicleType->id }} <br>
                                            <b>Fecha de Creación:</b> {{ $vehicleType->created_at }} <br>
                                            <b>Última Modificación:</b> {{ $vehicleType->updated_at }}"
                                        style="cursor: pointer">
                                            {{ $vehicleType->name }}
                                        </a>
                                    </td>
                                    @foreach ($vehicleType->prices as $price)
                                        <td
                                            class="vehicle-type-{{ $vehicleType->id }}"
                                            data-price-id="{{ $price->pivot->price_id }}">
                                            $ {{ $price->pivot->value }}
                                        </td>
                                    @endforeach
                                    <td>
                                        <button
                                            type="button"
                                            data-id="{{ $vehicleType->id }}"
                                            class="pull-right state-button change-state-{{ $vehicleType->id }}
                                            @if ($vehicleType->active == 1)
                                                btn btn-danger"
                                                >Desactivar
                                            @else
                                                pull-right btn btn-success"
                                                >Activar
                                            @endif
                                        </button>

                                        <button
                                            type="button"
                                            data-toggle="modal"
                                            data-target="#vehicle-types-modal"
                                            data-id="{{ $vehicleType->id }}"
                                            data-name="{{ $vehicleType->name }}"
                                            class="pull-right btn btn-primary edit-modal edit-{{ $vehicleType->id }}"
                                            @if ($vehicleType->active == 0)
                                                disabled="">
                                            @else
                                                >
                                            @endif
                                            Editar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="modal fade" id="vehicle-types-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Editar Tipo de Vehículo</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group col-md-12">
                                    <label class="col-lg-2 control-label" for="vehicle-type-name-modal">Nombre</label>
                                    <div class="col-lg-10">
                                        <input type="hidden" name="vehicle-type-id-modal" id="vehicle-type-id-modal">
                                        <input class="form-control" type="text" placeholder="Nombre del Tipo de Vehículo" name="vehicle-type-name-modal" id="vehicle-type-name-modal">
                                    </div>
                                </div>
                                <input type="hidden" name="vehicle-type-id-modal" id="vehicle-type-id-modal">
                                <div id="vehicle-type-prices-modal">
                                @foreach ($prices as $price)
                                    <div class="form-group col-md-12">
                                        <label class="col-lg-2 control-label">{{ $price->name }}</label>
                                        <div class="col-lg-10">
                                            <input class="form-control prices" name="{{ $price->id }}" id="vehicle-type-prices-modal-{{ $price->id }}" placeholder="Valor {{ $price->name }} ($)">
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="update-button">Editar</button>
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

    <script type="text/javascript" src="/js/yao/vehicleTypes.js"></script>

@endsection
