@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    <li class="active"><a href="{{route('ponencia.index')}}">Ponencia</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE PONENCIAS<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('ponencia.create') }}">Agregar Nueva Solicitud</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Detalles: </strong>Gestione la productividad académica de tipo Ponencia</div>
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Radicado</th>
                                <th>Título</th>
                                <th>Nombre del Evento</th>
                                <th>Tipo de Evento</th>
                                <th>Estado</th>
                                <th>Puntos de Bonificaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($ponencias !== null)
                            @foreach($ponencias as $d)
                            <tr>
                                <td>{{$d->solicitud->radicado}}</td>
                                <td>{{$d->solicitud->titulo}}</td>
                                <td>{{$d->nombre_evento}}</td>
                                <td>{{$d->tipo}}</td>
                                <td>
                                    @if($d->solicitud->estado == 'EN ESPERA')
                                    <label class="label label-warning">EN ESPERA</label>
                                    @elseif($d->solicitud->estado == 'EN ESTUDIO')
                                    <label class="label label-info">EN ESTUDIO</label>
                                    @elseif($d->solicitud->estado == 'APROBADA')
                                    <label class="label label-success">APROBADA</label>
                                    @else
                                    <label class="label label-danger">RECHAZADA</label>
                                    @endif
                                </td>
                                <td>{{$d->solicitud->puntos_bo}}</td>
                                <td>
                                    @if($d->solicitud->estado == 'EN ESPERA')
                                    <a href="{{ route('ponencia.edit',$d->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Solicitud"><i class="material-icons">mode_edit</i></a>
                                    <a href="{{ route('ponencia.show',$d->id)}}" class="btn bg-green waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Solicitud"><i class="material-icons">remove_red_eye</i></a>
                                    <a href="{{ route('ponencia.delete',$d->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Solicitud"><i class="material-icons">delete</i></a>
                                    <a href="{{ route('pqr.show',$d->solicitud_id)}}" class="btn bg-teal waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Nuevo PQR"><i class="material-icons">forum</i></a>
                                    @else
                                    <a href="{{ route('ponencia.show',$d->id)}}" class="btn bg-green waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Solicitud"><i class="material-icons">remove_red_eye</i></a>
                                    <a href="{{ route('pqr.show',$d->solicitud_id)}}" class="btn bg-teal waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Nuevo PQR"><i class="material-icons">forum</i></a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#tabla').DataTable();
    });
</script>
@endsection