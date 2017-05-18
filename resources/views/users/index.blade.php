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
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if ($roles->count() > 0)
                            <div class="row">
                                <div class="col-sm-12">
                                    <button
                                        type="button"
                                        class="pull-right btn btn-success create-modal"
                                        data-toggle="modal"
                                        data-target="#users-modal">Agregar
                                    </button>
                                </div>
                            </div>
                        @else
                            <a href="{{ url('/roles') }}">
                                <span class="label label-danger">No existen Roles.</span>
                            </a>
                        @endif

                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="users-table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Rol</th>
                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr id="user-{{ $user->id }}">
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->role->name }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <button
                                                    type="button"
                                                    data-id="{{ $user->id }}"
                                                    class="pull-right state-button change-state-{{ $user->id }}
                                                    @if ($user->active == 1)
                                                        btn btn-danger"
                                                        >Desactivar
                                                    @else
                                                        pull-right btn btn-success"
                                                        >Activar
                                                    @endif
                                                </button>
                                                <button
                                                    type="button"
                                                    class="pull-right btn btn-primary edit-modal edit-{{ $user->id }}"
                                                    data-toggle="modal"
                                                    data-target="#users-modal"
                                                    data-id="{{ $user->id }}"
                                                    data-name="{{ $user->name }}"
                                                    data-role="{{ $user->role_id }}"
                                                    data-phone="{{ $user->phone }}"
                                                    data-email="{{ $user->email }}"
                                                    data-password="{{ $user->password }}"
                                                    >Editar
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
        </div>

        @if ($roles->count() > 0)
            <div class="modal fade" id="users-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-md-6">
                                        <label>Nombre</label>
                                        <input type="hidden" name="user-id" id="user-id">
                                        <input class="form-control" name="user-name" id="user-name" placeholder="Nombre del Usuario">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Rol</label>
                                        <div>
                                            <select class="form-control" id="user-role" name="user-role">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Teléfono</label>
                                        <input class="form-control" name="user-phone" id="user-phone" placeholder="Teléfono">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Correo Electrónico</label>
                                        <input class="form-control" name="user-email" id="user-email" placeholder="Correo Electrónico">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Contraseña</label>
                                        <input class="form-control" type="password" name="user-password" id="user-password" placeholder="Contraseña">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Repetir Constraseña</label>
                                        <input class="form-control" type="password" name="user-password-c" id="user-password-c" placeholder="Confirmar Contraseña">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="modal-action-button"></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
@endsection

@section('libraries')
    {{-- <script type="text/javascript">
        $('[data-toggle="popover"]').popover({
            placement : 'bottom'
        });
    </script> --}}

    <script type="text/javascript" src="/js/yao/users.js"></script>

@endsection
