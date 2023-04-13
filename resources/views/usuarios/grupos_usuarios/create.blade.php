@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}">Usuarios</a></li>
    <li><a href="{{route('grupousuario.index')}}">Grupos de Usuarios</a></li>
    <li class="active"><a>Crear Grupo</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    USUARIOS DEL SISTEMA - GRUPOS DE USUARIOS O ROLES
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Agregue nuevos grupos,</strong> Los grupos de usuarios son los roles o agrupaciones de usuarios que permite asignarle privilegios a todo un conglomerado de usuarios que comparte funciones. Ejemplo de grupos de usuarios: ADMINISTRADOR, DOCENTE, ETC.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL GRUPO</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>'grupousuario.store','method'=>'POST','class'=>'form-horizontal'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Escriba el nombre del grupo o rol de usuario','required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('descripcion',null,['class'=>'form-control','placeholder'=>'Descripción del grupo (Opcional)']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::select('modulos[]',$modulos,null,['class'=>'form-control chosen-select','placeholder'=>'Seleccione los Módulos a los que el Grupo Tendrá Acceso','required','multiple']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('grupousuario.index')}}" class="btn bg-red waves-effect">Cancelar</a>
                                <button class="btn bg-indigo waves-effect" type="reset">Limpiar Formulario</button>
                                {!! Form::submit('Guardar',['class'=>'btn bg-green waves-effect']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(".chosen-select").chosen({});
</script>
@endsection