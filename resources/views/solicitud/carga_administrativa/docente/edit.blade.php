@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    <li><a href="{{route('admin.solicitud')}}">Carga Administrativa</a></li>
    <li><a href="{{route('docente.index')}}">Docentes</a></li>
    <li class="active"><a>Editar Docente</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE DOCENTES - EDITAR UN DOCENTE
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Edite los datos del docente.</strong>Para crear el usuario con el cual el docente nuevo ingresara al sistema debera dirigirse al modulo de usuarios en la opción crear usuario manual o usuario automatico.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DEL DOCENTE: {{$docente->primer_nombre." ".$docente->primer_apellido}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>['docente.update',$docente],'method'=>'PUT','class'=>'form-horizontal'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Tipo de Documento</label>
                                        {!! Form::select('tipodoc',['CEDULA DE CIUDADANIA'=>'CEDULA DE CIUDADANIA','CEDULA DE EXTRANJERIA'=>'CEDULA DE EXTRANJERIA','PASAPORTE'=>'PASAPORTE'],$docente->tipodoc,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Numero de Documento</label>
                                        {!! Form::text('numero_documento',$docente->numero_documento,['class'=>'form-control','placeholder'=>'Numero de documento del docente','required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Primer Nombre</label>
                                        {!! Form::text('primer_nombre',$docente->primer_nombre,['class'=>'form-control','placeholder'=>'Primer nombre del docente','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Segundo Nombre</label>
                                        {!! Form::text('segundo_nombre',$docente->segundo_nombre,['class'=>'form-control','placeholder'=>'Segundo nombre del docente']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Primer Apellido</label>
                                        {!! Form::text('primer_apellido',$docente->primer_apellido,['class'=>'form-control','placeholder'=>'Primer apellido del docente','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Segundo Apellido</label>
                                        {!! Form::text('segundo_apellido',$docente->segundo_apellido,['class'=>'form-control','placeholder'=>'Segundo apellido del docente']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Dedicación</label>
                                        {!! Form::select('dedicacion',['TIEMPO COMPLETO'=>'TIEMPO COMPLETO','MEDIO TIEMPO'=>'MEDIO TIEMPO'],$docente->dedicacion,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Categoria</label>
                                        {!! Form::select('categoria_id',$categorias,$docente->categoria_id,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Departamento</label>
                                        {!! Form::select('departamentof_id',$depto,$docente->departamentof_id,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">Puntos Iniciales</label>
                                        {!! Form::number('puntos_iniciales',$docente->puntos_iniciales,['class'=>'form-control','placeholder'=>'Puntos con los que ya cuenta el docente']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">Celular</label>
                                        {!! Form::text('celular',$docente->celular,['class'=>'form-control','placeholder'=>'Numero de celular']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">Telefono</label>
                                        {!! Form::email('telefono',$docente->telefono,['class'=>'form-control','placeholder'=>'Numero de telefono fijo']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-line">
                                        <label class="control-label">Correo Electronico</label>
                                        {!! Form::email('correo',$docente->correo,['class'=>'form-control','placeholder'=>'Dirección de correo','required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('docente.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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