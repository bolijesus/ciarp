@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}">Usuarios</a></li>
    <li class="active"><a href="{{route('pagina.index')}}">Páginas del Sistema</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    USUARIOS DEL SISTEMA - LISTADO DE TODOS LOS USUARIOS EN EL SISTEMA
                </h2>
            </div>
            <div class="body">
                <div class="responsive-table">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Identificación</th>
                                <th>Usuario</th>
                                <th>E-mail</th>
                                <th>Estado</th>
                                <th>Roles</th>
                                <th>Creado</th>
                                <th>Modificado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                            <tr>
                                <td>{{$usuario->identificacion}}</td>
                                <td>{{$usuario->nombres}} {{$usuario->apellidos}}</td>
                                <td>{{$usuario->email}}</td>
                                <td>@if($usuario->estado=='ACTIVO')<label class="label label-success">ACTIVO</label>@else<label class="label label-danger">INACTIVO</label>@endif</td>
                                <td>
                                    @foreach($usuario->grupousuarios as $grupo)
                                    {{$grupo->nombre}} - 
                                    @endforeach
                                </td>
                                <td>{{$usuario->created_at}}</td>
                                <td>{{$usuario->updated_at}}</td>
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