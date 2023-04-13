@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    <li class="active"><a href="{{route('software.index')}}">Software</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE SOFTWARE<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Detalles: </strong>Gestione la productividad académica de tipo Software</div>
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Radicado</th>
                                <th>Identificación</th>
                                <th>Docente</th>
                                <th>Título del Software</th>
                                <th>Titular</th>
                                <th>Estado</th>
                                <th>Puntos Salariales</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($software as $d)
                            <tr>
                                <td>{{$d->solicitud->radicado}}</td>
                                <td>{{$d->solicitud->docente->tipodoc." - ".$d->solicitud->docente->numero_documento}}</td>
                                <td>{{$d->solicitud->docente->primer_nombre." ".$d->solicitud->docente->segundo_nombre." ".$d->solicitud->docente->primer_apellido." ".$d->solicitud->docente->segundo_apellido}}</td>
                                <td>{{$d->solicitud->titulo}}</td>
                                <td>{{$d->titular}}</td>
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
                                <td>{{$d->solicitud->puntos_ps}}</td>
                                <td>
                                    <a href="{{ route('software.evaluar',$d->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Evaluar Solicitud"><i class="material-icons">check_circle</i></a>
                                    <a href="{{ route('software.show',$d->id)}}" class="btn bg-green waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Solicitud"><i class="material-icons">remove_red_eye</i></a>
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
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#tabla').DataTable();
    });
</script>
@endsection