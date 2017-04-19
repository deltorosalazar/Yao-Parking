@extends('layouts.dashboard')

@section('content')
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
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="movements-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($movements as $movement)
                                <tr id="movement-{{ $movement->id }}">
                                    <td>
                                        <a
                                        data-toggle="popover"
                                        title="<b>Detalles</b>"
                                        data-html="true"
                                        data-content="
                                            <b>ID:</b> {{ $movement->id }} <br>
                                            <b>Fecha de Creación:</b> {{ $movement->created_at }} <br>
                                            <b>Última Modificación:</b> {{ $movement->updated_at }}"
                                        style="cursor: pointer">
                                            {{ $movement->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            data-id="{{ $movement->id }}"
                                            class="pull-right state-button change-state-{{ $movement->id }}
                                            @if ($movement->active == 1)
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

            <div class="col-sm-6">
                <div class="alert alert-danger">
                    <h4>Aviso</h4>
                    <p>Sólo se han definido estos movimientos. Por tal razón no es posible agregarlos o modificarlos.</p>
                </div>
            </div>
        </div>

@endsection


@section('libraries')
    <script type="text/javascript">
        $('[data-toggle="popover"]').popover({
            placement : 'right'
        });
    </script>
@endsection
