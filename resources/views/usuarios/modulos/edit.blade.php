@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.usuarios')}}">Usuarios</a></li>
    <li><a href="{{route('modulo.index')}}">Módulos del Sistema</a></li>
    <li class="active"><a>Editar Módulo</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    USUARIOS DEL SISTEMA - MÓDULOS GENERALES DEL SISTEMA
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-deep-orange alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Nota: </strong> No modifique los nombres de los módulos ya creados ya que puede ocasionar fallas en el sistema. Hágalo si y solo si el desarrollador indica la necesidad de la operación. El nombre del módulo debe iniciar con "MOD_" seguido del nombre que usted desee.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">EDITAR DATOS DEL MÓDULO: {{$modulo->nombre}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['modulo.update',$modulo],'method'=>'PUT','class'=>'form-horizontal'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('nombre',$modulo->nombre,['class'=>'form-control','placeholder'=>'Escriba el nombre del módulo u opción de menú','required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <br/>{!! Form::text('descripcion',$modulo->descripcion,['class'=>'form-control','placeholder'=>'Descripción del módulo (Opcional)']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('modulo.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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