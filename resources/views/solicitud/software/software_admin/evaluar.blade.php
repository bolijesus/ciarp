@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    <li class="active"><a href="{{route('software.indexadmin')}}">Software</a></li>
    <li class="active"><a>Evaluar Productividad</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE SOFTWARE - EVALUAR PRODUCTIVIDAD
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Evalue la productivadad académica seleccionada.</strong>
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h2> DATOS DE LA PRODUCTIVIDAD ACADÉMICA</h2>
                </br><div class="row clearfix">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="read">
                                    <td class="contact"><b>Radicado</b></td>
                                    <td class="subject">{{$solicitud->radicado}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Identificación</b></td>
                                    <td class="subject">{{$docente->tipodoc." - ".$docente->numero_documento}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Docente</b></td>
                                    <td class="subject">{{$docente->primer_nombre." ".$docente->segundo_nombre." ".$docente->primer_apellido." ".$docente->segundo_apellido}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Tipo de Solicitud</b></td>
                                    <td class="subject">{{$solicitud->tipo}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Titulo</b></td>
                                    <td class="subject">{{$solicitud->titulo}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Titular</b></td>
                                    <td class="subject">{{$software->titular}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Número de Autores</b></td>
                                    <td class="subject">{{$solicitud->num_autores}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Autores</b></td>
                                    <td class="subject">{{$software->autores}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Puntos Salariales Aproximados</b></td>
                                    <td class="subject">{{$solicitud->puntos_aproximados_ps}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Puntos de Bonificación Aproximados</b></td>
                                    <td class="subject">{{$solicitud->puntos_aproximados_bo}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h1 class="card-inside-title">EVALUAR SOFTWARE: {{$solicitud->titulo}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>'software.calificar','method'=>'POST','class'=>'form-horizontal','files'=>'true'])!!}
                        <div class="col-md-12">
                            <input type="hidden" name="software_id" value="{{$software->id}}" />
                            <input type="hidden" name="solicitud_id" value="{{$solicitud->id}}" />
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Estado</label>
                                        {!! Form::select('estado',['APROBADA'=>'APROBADA','RECHAZADA'=>'RECHAZADA'],null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-line">
                                        <label class="control-label">Puntos Salariales</label>
                                        {!! Form::number('puntos_ps',null,['class'=>'form-control','placeholder'=>'Puntos salariales a asignar','required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="form-line">
                                        <label class="control-label">Observacion</label>
                                        <br/><textarea class="form-control"  name="observacion"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('software.indexadmin')}}" class="btn bg-red waves-effect">Cancelar</a>
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