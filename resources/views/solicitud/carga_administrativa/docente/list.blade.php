@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    <li><a href="{{route('admin.solicitud')}}">Carga Administrativa</a></li>
    <li class="active"><a href="{{route('docente.index')}}">Docentes</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE LOS DOCENTES<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('docente.create') }}">Agregar Nuevo Docente</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Detalles: </strong>Gestione la información de los docentes.</div>
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Identificación</th>
                                <th>Nombre</th>
                                <th>Dedicación</th>
                                <th>E-mail</th>
                                <th>Celular</th>
                                <th>Puntos</th>
                                <th>Departamento</th>
                                <th>Catégoria</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($docentes as $d)
                            <tr>
                                <td>{{$d->numero_documento}}</td>
                                <td>{{$d->primer_nombre." ".$d->segundo_nombre." ".$d->primer_apellido." ".$d->segundo_apellido}}</td>
                                <td>{{$d->dedicacion}}</td>
                                <td>{{$d->correo}}</td>
                                <td>{{$d->celular}}</td>
                                <td>{{$d->puntos_iniciales}}</td>
                                <td>{{$d->departamentof->nombre}}</td>
                                <td>{{$d->categoria->nombre}}</td>
                                <td>
                                    <a href="{{ route('docente.edit',$d->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Docente"><i class="material-icons">mode_edit</i></a>
                                    <a href="{{ route('docente.delete',$d->id)}}" class="btn bg-red waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar Docente"><i class="material-icons">delete</i></a>
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