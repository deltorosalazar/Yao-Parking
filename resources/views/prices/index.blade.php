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
                        <h3 class="panel-title">Agregar Tarifa</h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-component price_name_error hidden">
                            <div class="alert alert-dismissible alert-danger">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong class="myError">Error!</strong>
                            </div>
                            <div id="source-button" class="btn btn-primary btn-xs" style="display: none;">&lt; &gt;</div>
                        </div>

                        <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control" name="price_name" id="price_name" placeholder="Nombre de la Tarifa" disabled="">
                        </div>
                        <div class="form-group">
                            <button type="button" class="pull-right btn btn-primary" id="store-button" disabled="">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="prices-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prices as $price)
                                <tr id="price-{{ $price->id }}">
                                    <td>
                                        <a
                                        data-toggle="popover"
                                        title="<b>Detalles</b>"
                                        data-html="true"
                                        data-content="
                                            <b>ID:</b> {{ $price->id }} <br>
                                            <b>Fecha de Creación:</b> {{ $price->created_at }} <br>
                                            <b>Última Modificación:</b> {{ $price->updated_at }}"
                                        style="cursor: pointer">
                                            {{ $price->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <button disabled
                                            type="button"
                                            data-id="{{ $price->id }}"
                                            class="pull-right state-button change-state-{{ $price->id }}
                                            @if ($price->active == 1)
                                                btn btn-danger"
                                                >Desactivar
                                            @else
                                                pull-right btn btn-success"
                                                >Activar
                                            @endif
                                        </button>

                                        <button disabled=""
                                            type="button"
                                            data-toggle="modal"
                                            data-target="#prices-modal"
                                            data-id="{{ $price->id }}"
                                            data-name="{{ $price->name }}"
                                            class="pull-right btn btn-primary edit-modal edit-{{ $price->id }}"
                                            @if ($price->active == 0)
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


        <div class="modal fade" id="prices-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Editar Tarifa</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="price-name-modal">Nombre</label>
                                    <div class="col-lg-10">
                                        <input type="hidden" name="price-id-modal" id="price-id-modal">
                                        <input class="form-control" type="text" placeholder="Nombre del Tarifa" name="price-name-modal" id="price-name-modal">
                                    </div>
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

    <script type="text/javascript" src="/js/yao/prices.js"></script>

@endsection
