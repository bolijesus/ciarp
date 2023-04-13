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
                    USUARIOS DEL SISTEMA - PÁGINAS DEL SISTEMA<small>Haga clic en el botón de 3 puntos de la derecha de este título para agregar un nuevo registro.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ route('pagina.create') }}">Agregar Nueva Página</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Detalles: </strong>Las paginas o ítems de los módulos del sistema son las funcionalidades más específicas o detalladas de los módulos. Ejemplo de página general: PAG_MODULOS, PAG_PAGINAS, PAG_USUARIOS, PAG_PRIVILEGIOS, ETC.
                    <br/><strong>Nota: </strong> No modifique los nombres de las páginas ya creadas ya que puede ocasionar fallas en el sistema.
                </div>
                <div class="table-responsive">
                    <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Página</th>
                                <th>Descripción</th>
                                <th>Creado</th>
                                <th>Modificado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paginas as $pagina)
                            <tr>
                                <td>{{$pagina->id}}</td>
                                <td>{{$pagina->nombre}}</td>
                                <td>{{$pagina->descripcion}}</td>
                                <td>{{$pagina->created_at}}</td>
                                <td>{{$pagina->updated_at}}</td>
                                <td style="text-align: center;">
                                    <a href="{{ route('pagina.edit',$pagina->id)}}" class="btn bg-indigo waves-effect btn-xs" data-toggle="tooltip" data-placement="top" title="Editar Página"><i class="material-icons">mode_edit</i></a>
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