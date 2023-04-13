@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    <li><a href="{{route('admin.solicitud')}}">Artículos Científicos</a></li>
    <li class="active"><a href="{{route('articulo.index')}}">Artículos</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE ARTÍCULOS CIENTIFICOS<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('articulo.create') }}">Agregar Nueva Solicitud</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Detalles: </strong>Gestione las solicitudes de tipo Artículo</div>
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Radicado</th>
                                <th>Título del Artículo</th>
                                <th>Clasificación</th>
                                <th>Estado</th>
                                <th>Puntos Salariales</th>
                                <th>Acta</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($articulos !== null)
                            @foreach($articulos as $d)
                            <tr>
                                <td>{{$d->solicitud->radicado}}</td>
                                <td>{{$d->solicitud->titulo}}</td>
                                <td>{{$d->clasificacion}}</td>
                                <td>@if($d->solicitud->estado == 'EN ESPERA')
                                    <label class="label label-warning">EN ESPERA</label>
                                    @elseif($d->solicitud->estado == 'EN ESTUDIO')
                                    <label class="label label-info">EN ESTUDIO</label>
                                    @elseif($d->solicitud->estado == 'APROBADA')
                                    <label class="label label-success">APROBADA</label>
                                    @else
                                    <label class="label label-danger">RECHAZADA</label>
                                    @endif
                                </td>
                                <td>{{$d->solicitud->puntos_ps}}</td>
                                <td><a target="_blank" href="{{asset('docs/articulos/acta/'.$d->solicitud->acta)}}">{{$d->solicitud->acta}}</a></td>
                                <td>
                                    @if($d->solicitud->estado == 'EN ESPERA')
                                    <a href="{{ route('articulo.edit',$d->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Solicitud"><i class="material-icons">mode_edit</i></a>
                                    <a href="{{ route('articulo.show',$d->id)}}" class="btn bg-green waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Solicitud"><i class="material-icons">remove_red_eye</i></a>
                                    <a href="{{ route('articulo.delete',$d->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Solicitud"><i class="material-icons">delete</i></a>
                                    <a href="{{ route('pqr.show',$d->solicitud_id)}}" class="btn bg-teal waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Nuevo PQR"><i class="material-icons">forum</i></a>
                                    @else
                                    <a href="{{ route('articulo.show',$d->id)}}" class="btn bg-green waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Solicitud"><i class="material-icons">remove_red_eye</i></a>
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