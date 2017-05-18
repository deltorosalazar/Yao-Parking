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
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Agregar Impuesto</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input class="form-control" name="tax-name" id="tax-name" placeholder="Nombre del Impuesto" disabled="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Porcentaje (%)</label>
                                    <input class="form-control" name="tax-percentage" id="tax-percentage" placeholder="%" disabled="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" class="pull-right btn btn-primary disabled" id="store-button">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="taxes-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Porcentaje</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($taxes as $tax)
                                <tr id="tax-{{ $tax->id }}">
                                    <td>
                                        <a
                                        data-toggle="popover"
                                        title="<b>Detalles</b>"
                                        data-html="true"
                                        data-content="
                                            <b>ID:</b> {{ $tax->id }} <br>
                                            <b>Fecha de Creación:</b> {{ $tax->created_at }} <br>
                                            <b>Última Modificación:</b> {{ $tax->updated_at }}"
                                        style="cursor: pointer">
                                            {{ $tax->name }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $tax->percentage }}%
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            data-id="{{ $tax->id }}"
                                            class="pull-right state-button change-state-{{ $tax->id }} disabled
                                            @if ($tax->active == 1)
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
                                            data-target="#taxes-modal"
                                            data-id="{{ $tax->id }}"
                                            data-name="{{ $tax->name }}"
                                            data-percentage="{{ $tax->percentage }}"
                                            class="pull-right btn btn-primary edit-modal edit-{{ $tax->id }}"
                                            @if ($tax->active == 0)
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


        <div class="modal fade" id="taxes-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Editar Impuesto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="col-lg-6 control-label" for="tax-name-modal">Nombre</label>
                                    <div class="col-lg-12">
                                        <input type="hidden" name="tax-id-modal" id="tax-id-modal">
                                        <input class="form-control" type="text" placeholder="Nombre del Rol" name="tax-name-modal" id="tax-name-modal" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-lg-7 control-label" for="tax-percentage-modal">Porcentaje</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" type="text" placeholder="%" name="tax-percentage-modal" id="tax-percentage-modal">
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

    <script type="text/javascript" src="/js/yao/taxes.js"></script>

@endsection
