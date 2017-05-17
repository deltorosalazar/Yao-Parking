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
                        <h3 class="panel-title">Agregar Rol</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control" name="role-name" id="role-name" placeholder="Nombre del Rol" disabled>
                        </div>
                        <div class="form-group">
                            <button type="button" class="pull-right btn btn-primary" id="store-button" disabled>Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="roles-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr id="role-{{ $role->id }}">
                                    <td>
                                        <a
                                        data-toggle="popover"
                                        title="<b>Detalles</b>"
                                        data-html="true"
                                        data-content="
                                            <b>ID:</b> {{ $role->id }} <br>
                                            <b>Fecha de Creación:</b> {{ $role->created_at }} <br>
                                            <b>Última Modificación:</b> {{ $role->updated_at }}"
                                        style="cursor: pointer">
                                            {{ $role->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            data-id="{{ $role->id }}"
                                            class="pull-right state-button change-state-{{ $role->id }}
                                            @if ($role->active == 1)
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
                                            data-target="#roles-modal"
                                            data-id="{{ $role->id }}"
                                            data-name="{{ $role->name }}"
                                            class="pull-right btn btn-primary edit-modal edit-{{ $role->id }}"
                                            @if ($role->active == 0)
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


        <div class="modal fade" id="roles-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Editar Rol</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="role-name-modal">Nombre</label>
                                    <div class="col-lg-10">
                                        <input type="hidden" name="role-id-modal" id="role-id-modal">
                                        <input class="form-control" type="text" placeholder="Nombre del Rol" name="role-name-modal" id="role-name-modal">
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

    <script type="text/javascript" src="/js/yao/roles.js"></script>

@endsection
