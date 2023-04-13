@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    <li class="active"><a href="{{route('articulo.indexadmin')}}">Artículos</a></li>
    <li class="active"><a>Evaluar Productividad</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE ARTICULOS CIENTIFICOS - EVALUAR PRODUCTIVIDAD
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
                                    <td class="contact"><b>Nombre de la Revista</b></td>
                                    <td class="subject">{{$articulo->nombre_revista}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Indexada</b></td>
                                    <td class="subject">{{$articulo->indexada}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Clasificación</b></td>
                                    <td class="subject">{{$articulo->clasificacion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Fecha de Publicación</b></td>
                                    <td class="subject">{{$articulo->fechapublicacion}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Puntos Salariales Solicitados</b></td>
                                    <td class="subject">{{$articulo->ps_solicitados}}</td>
                                </tr>
                                <tr class="read">
                                    <td class="contact"><b>Bonificaciones Solicitados</b></td>
                                    <td class="subject">{{$articulo->bo_solicitados}}</td>
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
                <h1 class="card-inside-title">EVALUAR ARTICULO: {{$solicitud->titulo}}</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>'articulo.calificar','method'=>'POST','class'=>'form-horizontal','files'=>'true'])!!}
                        <div class="col-md-12">
                            <input type="hidden" name="index" id="index" value="{{$solicitud->tipo}}" />
                            <input type="hidden" name="articulo_id" value="{{$articulo->id}}" />
                            <input type="hidden" name="solicitud_id" value="{{$solicitud->id}}" />
                            <div class="form-group">
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Estado</label>
                                        {!! Form::select('estado',['APROBADA'=>'APROBADA','RECHAZADA'=>'RECHAZADA'],null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Puntos Salariales</label>
                                        {!! Form::number('puntos_ps',null,['class'=>'form-control','placeholder'=>'Puntos salariales a asignar','required','id'=>'sal']) !!}
                                    </div>
                                </div><div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Bonificaciones</label>
                                        {!! Form::number('puntos_bo',null,['class'=>'form-control','placeholder'=>'Bonificaciones a asignar','required','id'=>'boni']) !!}
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
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Acta</label>
                                        <input class="form-control" type="file" required="required" name="acta">    
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('articulo.indexadmin')}}" class="btn bg-red waves-effect">Cancelar</a>
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
    $(document).ready(function () {
        var ind = $("#index").val();
        if (ind == "ARTICULO INDEXADO") {
            $("#sal").val(0);
            $("#sal").attr('disabled', true);
        } else {
            $("#boni").val(0);
            $("#boni").attr('disabled', true);
        }
    });
    $(".chosen-select").chosen({});
</script>
@endsection