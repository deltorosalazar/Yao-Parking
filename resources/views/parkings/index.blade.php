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
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Agregar Parqueadero</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control" name="parking_name" id="parking_name" placeholder="Nombre del Parqueadero" value="">
                        </div>
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
                                <th>Nombre</th>
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
                                            <b>ID:</b> {{ $parking->id }} <br>
                                            <b>Fecha de Creación:</b> {{ $parking->created_at }} <br>
                                            <b>Última Modificación:</b> {{ $parking->updated_at }}"
                                        {{-- style="cursor: pointer"> --}}
                                        href="/parkings/show/{{ $parking->id }}">
                                            {{ $parking->name }}
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

                                        <button
                                            type="button"
                                            data-toggle="modal"
                                            data-target="#parkings-modal"
                                            data-id="{{ $parking->id }}"
                                            data-name="{{ $parking->name }}"
                                            class="pull-right btn btn-primary edit-modal edit-{{ $parking->id }}"
                                            @if ($parking->active == 0)
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


        <div class="modal fade" id="parkings-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Editar Parqueadero</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="parking-name-modal">Nombre</label>
                                    <div class="col-lg-10">
                                        <input type="hidden" name="parking-id-modal" id="parking-id-modal">
                                        <input class="form-control" type="text" placeholder="Nombre del Parqueadero" name="parking-name-modal" id="parking-name-modal">
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

    <script type="text/javascript" src="/js/yao/parkings.js"></script>

@endsection
