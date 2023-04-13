@extends('layouts.admin')
@section('breadcrumb')
<ol class="breadcrumb breadcrumb-bg-blue-grey" style="margin-bottom: 30px;">
    <li><a href="{{route('inicio')}}">Inicio</a></li>
    <li><a href="{{route('admin.solicitud')}}">Solicitud</a></li>
    <li><a href="{{route('admin.solicitud')}}">Recursos Académicos</a></li>
    <li><a href="{{route('fechapqr.index')}}">Fechas de Peticiones, Quejas y Reclamos</a></li>
    <li class="active"><a>Agregar Fecha</a></li>
</ol>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    GESTIÓN DE FECHAS DE PQR - AGREGAR NUEVA FECHA
                </h2>
            </div>
            <div class="body">
                <div class="alert bg-green alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Agregue nuevas fechas.</strong> Gestione las fechas en las que los docentes pueden realizar peticiones,quejas y reclamos sobre una productivad académica. Recuerde de que solo una fecha puede estar en estado ACTIVA.
                </div>
                <div class="col-md-12">
                    @component('layouts.errors')
                    @endcomponent
                </div>
                <h1 class="card-inside-title">DATOS DE LA FECHA</h1>
                <div class="row clearfix">
                    <div class="col-md-12">
                        {!! Form::open(['route'=>'fechapqr.store','method'=>'POST','class'=>'form-horizontal'])!!}
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Estado</label>
                                        {!! Form::select('estado',['ACTIVA'=>'ACTIVA','INACTIVA'=>'INACTIVA'],null,['class'=>'form-control','placeholder'=>'-- Seleccione una opción --','required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Fecha Inicio</label>
                                        <input class="form-control" required="required" name="fechainicio" type="datetime-local" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-line">
                                        <label class="control-label">Fecha Fin</label>
                                        <input class="form-control" required="required" name="fechafin" type="datetime-local" />

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <br/><br/><a href="{{route('fechapqr.index')}}" class="btn bg-red waves-effect">Cancelar</a>
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