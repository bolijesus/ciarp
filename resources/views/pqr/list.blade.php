@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li class="active">Preguntas, Quejas y Reclamos </li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN PREGUNTAS, QUEJAS Y RECLAMOS<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Detalles: </strong>Gestione las preguntas, quejas y reclamos relacionadas a una solicitud de productividad académica. Para crear una nueva petición, queja o reclamo debe dirigirce al modulo solicitud, y seleccionar la solicitud sobre la cual desea hacer la pqr.</div>
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Autor</th>
                                <th>Asunto</th>
                                <th>Radicado</th>
                                <th>Título de la Productividad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pqr as $d)
                            <tr>
                                <td>{{$d->user->nombres." ".$d->user->apellidos}}</td>
                                <td>{{$d->asunto}}</td>
                                <td>{{$d->solicitud->radicado}}</td>
                                <td>{{$d->solicitud->titulo}}</td>
                                <td>
                                    <a href="{{ route('pqr.show',$d->solicitud_id)}}" class="btn bg-teal waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Ver Solicitud"><i class="material-icons">forum</i></a>
                                    <a href="{{ route('pqr.delete',$d->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Solicitud"><i class="material-icons">delete</i></a>
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